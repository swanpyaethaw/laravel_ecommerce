<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            @if(session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border">
                        @if($product->productImages)
                            <img src="{{ asset($product->productImages[0]->image) }}" class="w-100" alt="Img">
                        @else
                            No Image Added
                        @endif

                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            {{ $product->name }}

                        </h4>
                        <hr>
                        <p class="product-path">
                            Home / {{ $category->name }} / {{ $product->name }}
                        </p>
                        <div>
                            <span class="selling-price">{{ $product->selling_price }}</span>
                            <span class="original-price">{{ $product->original_price }}</span>
                        </div>
                        <div>
                            @if($product->productColors->count() > 0)
                                @if ($product->productColors)
                                    @foreach ($product->productColors as $productColor)
                                    {{-- <input type="radio" name="colorSelection" value="{{ $productColor->id }}"> {{ $productColor->color->name }} --}}
                                    <label wire:click="colorSelected({{ $productColor->id }})" class="colorSelectionLabel" style="background-color: {{ $productColor->color->code }}">{{ $productColor->color->name }}</label>
                                    @endforeach
                                    @if ($this->productColorSelectedQty == 'outOfStock')
                                        <label class="btn-sm py-1 mt-2 text-white bg-danger">Out of Stock</label>
                                    @elseif($this->productColorSelectedQty)
                                        <label class="btn-sm py-1 mt-2 text-white  bg-success">In stock</label>
                                    @endif
                                @endif

                            @else

                                @if($product->quantity)
                                    <label class="btn-sm py-1 mt-2 text-white  bg-success">In Stock</label>
                                @else
                                    <label class="btn-sm py-1 mt-2 text-white bg-danger">Out of Stock</label>
                                @endif

                            @endif




                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span wire:click="decrementQty" class="btn btn1"><i class="material-icons md-18">remove</i></span>
                                <input type="text" wire:model="qtyCount" readonly value="{{ $this->qtyCount }}" class="input-quantity" />
                                <span wire:click="incrementQty" class="btn btn1"><i class="material-icons md-18">add</i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" wire:click="addToCart({{$product->id}})" class="btn btn1">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons pe-1">add_shopping_cart</i>
                                    <span wire:loading.remove wire:target="addToCart">
                                        Add To Cart
                                    </span>
                                    <span wire:loading wire:target="addToCart">
                                        ...Adding
                                    </span>
                                </div>

                            </button>
                            <button type="button" wire:click="addToWishList({{ $product->id }})" class="btn btn1">
                                <div class="d-flex align-items-center">
                                    <i class="material-icons pe-1">playlist_add</i>
                                    <span wire:loading.remove wire:target="addToWishList">
                                        <i class="fa fa-heart"></i>
                                    Add To Wishlist
                                    </span>
                                    <span wire:loading wire:target="addToWishList">
                                        ...Adding
                                    </span>
                                </div>
                            </button>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-0">Small Description</h5>
                            <p>
                                {{ $product->small_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4>Description</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
