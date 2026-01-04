<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Payment;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->latest()->paginate(10);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::all();
        $setting = Setting::first();
        
        $lastInvoice = Invoice::latest()->first();
        $nextNumber = $lastInvoice ? (int) filter_var($lastInvoice->invoice_number, FILTER_SANITIZE_NUMBER_INT) + 1 : 1001;
        $invoiceNumber = ($setting->invoice_prefix ?? 'INV-') . $nextNumber;

        return view('admin.invoices.create', compact('customers', 'products', 'invoiceNumber'));
    }

    public function store(InvoiceRequest $request)
    {
        DB::transaction(function () use ($request) {
            $invoice = Invoice::create($request->validated());
            $invoice->update(['balance_due' => $invoice->grand_total]);
            
            foreach ($request->items as $item) {
                $invoice->items()->create($item);
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('customer', 'items', 'payments');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');
        $customers = Customer::where('is_active', true)->get();
        $products = Product::all();
        return view('admin.invoices.edit', compact('invoice', 'customers', 'products'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        DB::transaction(function () use ($request, $invoice) {
            $invoice->update($request->validated());
            $invoice->update(['balance_due' => $invoice->grand_total - $invoice->amount_paid]);
            $invoice->items()->delete();
            
            foreach ($request->items as $item) {
                $invoice->items()->create($item);
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('customer', 'items');
        $setting = Setting::first();
        $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice', 'setting'));
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
