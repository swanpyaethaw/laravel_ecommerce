@extends('layouts.admin')

@section('title','Order List')

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
                        <h4 class="text-primary">
                            <i class="material-icons">shopping_cart</i>Order Details
                            <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm float-end mx-1">Back</a>
                            <a href="{{ url('admin/invoice/'.$order->id.'/generate') }}" class="btn btn-primary btn-sm float-end mx-1">Download Invoice</a>
                            <a href="{{ url('admin/invoice/'.$order->id) }}" class="btn btn-warning btn-sm float-end mx-1" target="_blank">View Invoice</a>
                            <a href="{{ url('admin/invoice/'.$order->id.'/mail') }}" class="btn btn-info btn-sm float-end mx-1">Send Via Invoice Mail</a>

                        </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <hr>
                            <h6>Order Id: {{ $order->id }}</h6>
                            <h6>Tracking Id/No: {{ $order->tracking_no }}</h6>
                            <h6>Ordered Date: {{ $order->created_at->format('d-m-Y H:i A') }}</h6>
                            <h6>Payment Mode: {{ $order->payment_mode }}</h6>
                            <h6 class="border p-2 text-success">
                                Order Status Message: <span class="text-uppercase">{{ $order->status_message }}</span>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5>User Details</h5>
                            <hr>
                            <h6>Full Name: {{ $order->full_name }}</h6>
                            <h6>Email: {{ $order->email }}</h6>
                            <h6>Phone: {{ $order->phone }}</h6>
                            <h6>Address: {{ $order->address }}</h6>
                            <h6>Pin code: {{ $order->pincode }}</h6>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach ($order->orderItems as $orderItem)
                                <tr>
                                    <td width="10%">{{ $orderItem->id }}</td>
                                    <td width="10%">
                                        @if($orderItem->product->productImages)
                                            <img src="{{ asset($orderItem->product->productImages[0]->image) }}"  style="width:50px;height:50px" alt="">
                                        @else
                                            <img src=""  style="width:50px;height:50px" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $orderItem->product->name }}
                                        @if($orderItem->productColor)
                                            @if($orderItem->productColor->color)
                                                <span>-Color: {{ $orderItem->productColor->color->name }}</span>
                                            @endif
                                        @endif
                                    </td>

                                    <td width="10%">{{ $orderItem->product->selling_price }}</td>
                                    <td width="10%">{{ $orderItem->quantity }}</td>
                                    <td width="10%" class="fw-bold">${{ $orderItem->product->selling_price * $orderItem->quantity }}</td>
                                </tr>
                                @php
                                    $totalPrice += $orderItem->product->selling_price * $orderItem->quantity
                                @endphp
                            @endforeach
                            <tr class="fw-bold">
                                <td colspan="5">Total Amount:</td>
                                <td colspan="1">${{ $totalPrice }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card border mt-3">
                <div class="card-body">
                    <h4>Order Process(Order Status Update)</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{ url('admin/orders/'.$order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label>Update Your Order Status</label>
                                <div class="input-group">
                                    <select name="order_status" class="select-control">
                                        <option value="">Select All Status</option>
                                            <option value="in progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                            <option value="pending">Pending</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="out for delivery">Out for delivery</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <br>
                            <h4 class="mt-3">Current Order Status: <span class="text-uppercase">{{ $order->status_message }}</span></h4>
                        </div>
                    </div>

                </div>
            </div>
            </div>
    </div>


@endsection



