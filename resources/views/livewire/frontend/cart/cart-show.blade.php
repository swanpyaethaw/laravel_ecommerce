<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <h4>Cart List</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">

                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Products</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Price</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Quantity</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Total</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Remove</h4>
                                </div>
                            </div>
                        </div>
                        @forelse ($cart as $cartItem)
                            @if ($cartItem->product)
                            <div class="cart-item">
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <a href="{{ url('collections/'.$cartItem->product->category->slug.'/'.$cartItem->product->slug) }}">
                                            <label class="product-name">
                                                @if($cartItem->product->productImages)
                                                    <img src="{{ asset($cartItem->product->productImages[0]->image) }}" style="width: 50px; height: 50px" alt="">
                                                @else
                                                    <img src="" style="width: 50px; height: 50px" alt="">
                                                @endif
                                                {{ $cartItem->product->name }}
                                                @if($cartItem->productColor)
                                                    @if($cartItem->productColor->color)
                                                    <span>-Color: {{ $cartItem->productColor->color->name }}</span>
                                                    @endif
                                                @endif
                                            </label>
                                        </a>
                                    </div>
                                    <div class="col-md-1 my-auto">
                                        <label class="price">{{ $cartItem->product->selling_price }} </label>
                                    </div>
                                    <div class="col-md-2 col-7 my-auto">
                                        <div class="quantity">
                                            <div class="input-group">
                                                <button type="button" wire:click="decrementQty({{$cartItem->id}})" wire:loading.attr = "disabled" class="btn btn1"><i class="bi bi-dash"></i></button>
                                                <input type="text" value="{{ $cartItem->quantity }}" class="input-quantity" />
                                                <button type="button" wire:click="incrementQty({{$cartItem->id}})" wire:loading.attr = "disabled" class="btn btn1"><i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 my-auto">
                                        <label class="price">{{ $cartItem->product->selling_price * $cartItem->quantity }} </label>
                                         @php
                                            $totalPrice += $cartItem->product->selling_price * $cartItem->quantity;
                                        @endphp
                                    </div>

                                    <div class="col-md-2 col-5 my-auto">
                                        <div class="remove">
                                            <button type="button" wire:click="removeCartItem({{$cartItem->id}})" class="btn btn-danger btn-sm">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-trash"></i>
                                                    <span wire:loading.remove wire:target="removeCartItem({{$cartItem->id}})">
                                                     Remove
                                                    </span>
                                                    <span wire:loading wire:target="removeCartItem({{$cartItem->id}})">
                                                    Removing...
                                                    </span>
                                                </div>


                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        @empty
                            No Cart Item Available
                        @endforelse


                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 my-md-auto mt-3">
                    <h5>
                        Get the best deals & offers <a href="{{url('/collections')}}">shop now</a>
                    </h5>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="shadow-sm bg-white p-3">
                        <h4>Total:
                            <span>${{ $totalPrice }}</span>
                        </h4>
                        <hr>
                        <a href="{{ url('/checkout') }}" class="btn btn-warning w-100">Checkout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
