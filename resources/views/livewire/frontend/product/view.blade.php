<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border" wire:ignore>
                        @if($product->productImages)
                            {{-- <img src="{{ asset($product->productImages[0]->image) }}" class="w-100" alt="Img"> --}}
                            <div class="exzoom" id="exzoom">
                                <!-- Images -->
                                <div class="exzoom_img_box">
                                  <ul class='exzoom_img_ul'>
                                    @foreach ($product->productImages as $image)
                                    <li><img src="{{ asset($image->image) }}"/></li>
                                    @endforeach
                                  </ul>
                                </div>
                                <!-- <a href="https://www.jqueryscript.net/tags.php?/Thumbnail/">Thumbnail</a> Nav-->
                                <div class="exzoom_nav"></div>
                                <!-- Nav Buttons -->
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                                </p>
                              </div>

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
                            <span class="selling-price">${{ $product->selling_price }}</span>
                            <span class="original-price">${{ $product->original_price }}</span>
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

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Related @if($category) {{ $category->name }} @endif Products</h4>
                    <div class="underline mb-3"></div>
                </div>

                <div class="col-md-12">
                    @if ($category)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($category->relatedProducts as $relatedProduct)
                                <div class="item">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                        <label class="stock bg-danger">New</label>
                                                    @if($relatedProduct->productImages->count() > 0)
                                                        <a href="{{ url('collections/'.$relatedProduct->category->slug.'/'.$relatedProduct->slug) }}">
                                                        <img src="{{ asset($relatedProduct->productImages[0]->image) }}" alt="{{ $relatedProduct->name }}">
                                                        </a>
                                                    @endif
                                            </div>
                                            <div class="product-card-body">
                                                    <p class="product-brand">{{ $relatedProduct->brand }}</p>
                                                    <h5 class="product-name">
                                                    <a href="{{ url('collections/'.$product->category->slug.'/'.$relatedProduct->slug) }}">
                                                            {{ $relatedProduct->name }}
                                                    </a>
                                                    </h5>
                                                    <div>
                                                        <span class="selling-price">${{ $relatedProduct->selling_price }}</span>
                                                        <span class="original-price">${{ $relatedProduct->original_price }}</span>
                                                    </div>

                                            </div>
                                        </div>
                                </div>
                        @endforeach
                        </div>
                    @else
                        <div class="p-2">
                            <h5>No Related Products Available</h5>
                        </div>
                    @endif

                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Related @if($product){{ $product->brand }} @endif Products</h4>
                    <div class="underline mb-3"></div>
                </div>
                <div class="col-md-12">
                    @if ($product)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($category->relatedProducts as $relatedProduct)
                                @if ($relatedProduct->brand == $product->brand)
                                    <div class="item">
                                            <div class="product-card">
                                                <div class="product-card-img">
                                                            <label class="stock bg-danger">New</label>
                                                        @if($relatedProduct->productImages->count() > 0)
                                                            <a href="{{ url('collections/'.$relatedProduct->category->slug.'/'.$relatedProduct->slug) }}">
                                                            <img src="{{ asset($relatedProduct->productImages[0]->image) }}" alt="{{ $relatedProduct->name }}">
                                                            </a>
                                                        @endif
                                                </div>
                                                <div class="product-card-body">
                                                        <p class="product-brand">{{ $relatedProduct->brand }}</p>
                                                        <h5 class="product-name">
                                                        <a href="{{ url('collections/'.$product->category->slug.'/'.$relatedProduct->slug) }}">
                                                                {{ $relatedProduct->name }}
                                                        </a>
                                                        </h5>
                                                        <div>
                                                            <span class="selling-price">${{ $relatedProduct->selling_price }}</span>
                                                            <span class="original-price">${{ $relatedProduct->original_price }}</span>
                                                        </div>

                                                </div>
                                            </div>
                                    </div>
                                @endif
                        @endforeach
                        </div>
                    @else
                        <div class="p-2">
                            <h5>No Related Products Available</h5>
                        </div>
                    @endif



                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(function(){

            $("#exzoom").exzoom({

            // thumbnail nav options
            "navWidth": 60,
            "navHeight": 60,
            "navItemNum": 5,
            "navItemMargin": 7,
            "navBorder": 1,

            // autoplay
            "autoPlay": false,

            // autoplay interval in milliseconds
            "autoPlayTimeout": 2000

            });

        });

        $('.four-carousel').owlCarousel({
        loop:true,
        margin:10,
        dots:true,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    })
    </script>
@endpush

