@extends('admin.layouts.app')

@section('title', 'Products & Services')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Products & Services</h4>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Item</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Tax %</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ format_currency($product->price) }}</td>
                    <td>{{ $product->tax_percentage }}%</td>
                    <td>
                        <span class="badge bg-secondary">{{ ucfirst($product->type) }}</span>
                    </td>
                    <td>{{ $product->stock ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-info">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $products->links() }}
    </div>
</div>
@endsection
