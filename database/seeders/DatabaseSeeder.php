<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@invoice.com',
            'password' => Hash::make('password'),
        ]);

        // Default Setting
        Setting::create([
            'company_name' => 'Global Solutions Inc.',
            'company_address' => '123 Business Road, Tech City, 54321',
            'company_phone' => '+1 234 567 890',
            'company_email' => 'contact@globalsolutions.com',
            'company_tax_id' => 'TAX12345678',
            'currency_symbol' => '$',
            'invoice_prefix' => 'INV-',
            'quote_prefix' => 'QT-',
        ]);

        // Sample Customers
        Customer::create([
            'name' => 'John Doe',
            'company_name' => 'Doe Enterprises',
            'email' => 'john@doe.com',
            'phone' => '9876543210',
            'address' => '456 Client St, City',
            'country' => 'USA',
            'is_active' => true,
        ]);

        // Sample Products
        Product::create([
            'name' => 'Web Design Service',
            'sku' => 'SRV-001',
            'description' => 'Professional custom web design',
            'price' => 500.00,
            'tax_percentage' => 10.00,
            'type' => 'service',
        ]);
    }
}
