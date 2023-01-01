@extends('layouts.admin')

@section('content')

     <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Product
                        <a href="{{ url('admin/products/create') }}" class="btn btn-sm btn-primary float-end">Add Product</a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->status == '1' ? 'hidden' : 'visible' }}</td>
                                <td>
                                    <a href="{{ url('admin/products/'.$product->id.'/edit') }}" class="btn btn-primary">Edit</a>
                                    <a href="{{ url('admin/products/'.$product->id.'/delete') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No Product</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
