<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'customers_count' => Customer::count(),
            'invoices_count' => Invoice::count(),
            'total_paid' => Invoice::sum('amount_paid'),
            'total_pending' => Invoice::sum('balance_due'),
        ];
        
        $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentInvoices'));
    }
}
