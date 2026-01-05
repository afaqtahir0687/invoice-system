<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Http\Requests\QuoteRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::with('customer')->latest()->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::all();
        $setting = Setting::first();
        
        $lastQuote = Quote::latest()->first();
        $nextNumber = $lastQuote ? (int) filter_var($lastQuote->quote_number, FILTER_SANITIZE_NUMBER_INT) + 1 : 1001;
        $quoteNumber = ($setting->quote_prefix ?? 'QT-') . $nextNumber;

        return view('admin.quotes.create', compact('customers', 'products', 'quoteNumber'));
    }

    public function store(QuoteRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/quotes'), $filename);
                    $imagePaths[] = 'uploads/quotes/' . $filename;
                }
                $data['images'] = $imagePaths;
            }
            
            $quote = Quote::create($data);
            
            foreach ($request->items as $item) {
                $quote->items()->create($item);
            }
        });

        return redirect()->route('quotes.index')->with('success', 'Quote created successfully.');
    }

    public function show(Quote $quote)
    {
        $quote->load('customer', 'items');
        return view('admin.quotes.show', compact('quote'));
    }

    public function edit(Quote $quote)
    {
        $quote->load('items');
        $customers = Customer::where('is_active', true)->get();
        $products = Product::all();
        return view('admin.quotes.edit', compact('quote', 'customers', 'products'));
    }

    public function update(QuoteRequest $request, Quote $quote)
    {
        DB::transaction(function () use ($request, $quote) {
            $data = $request->validated();
            
            // Handle image uploads
            if ($request->hasFile('images')) {
                // Delete old images if new ones are uploaded
                if ($quote->images) {
                    foreach ($quote->images as $oldImage) {
                        $oldImagePath = public_path($oldImage);
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
                
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/quotes'), $filename);
                    $imagePaths[] = 'uploads/quotes/' . $filename;
                }
                $data['images'] = $imagePaths;
            }
            
            $quote->update($data);
            $quote->items()->delete();
            
            foreach ($request->items as $item) {
                $quote->items()->create($item);
            }
        });

        return redirect()->route('quotes.index')->with('success', 'Quote updated successfully.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted successfully.');
    }

    public function convertToInvoice(Quote $quote)
    {
        $setting = Setting::first();
        $lastInvoice = Invoice::latest()->first();
        $nextNumber = $lastInvoice ? (int) filter_var($lastInvoice->invoice_number, FILTER_SANITIZE_NUMBER_INT) + 1 : 1001;
        $invoiceNumber = ($setting->invoice_prefix ?? 'INV-') . $nextNumber;

        DB::transaction(function () use ($quote, $invoiceNumber) {
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'invoice_date' => now(),
                'due_date' => now()->addDays(7),
                'customer_id' => $quote->customer_id,
                'subtotal' => $quote->subtotal,
                'total_tax' => $quote->total_tax,
                'total_discount' => $quote->total_discount,
                'shipping' => $quote->shipping,
                'grand_total' => $quote->grand_total,
                'balance_due' => $quote->grand_total,
                'status' => 'Unpaid',
                'notes' => $quote->notes,
            ]);

            foreach ($quote->items as $item) {
                $invoice->items()->create([
                    'description' => $item->description,
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'tax_percentage' => $item->tax_percentage,
                    'discount' => $item->discount,
                    'total' => $item->total,
                ]);
            }

            $quote->update(['status' => 'Invoiced']);
        });

        return redirect()->route('invoices.index')->with('success', 'Quote converted to Invoice successfully.');
    }

    public function downloadPdf(Quote $quote)
    {
        $quote->load('customer', 'items');
        $setting = Setting::first();
        $pdf = Pdf::loadView('admin.quotes.pdf', compact('quote', 'setting'));
        return $pdf->download($quote->quote_number . '.pdf');
    }
}
