<div>
    <!--Review Modal -->
    <div wire:ignore.self class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Review {{ $product->name }}</h1>
            <button type="button" class="btn-close" wire:click="resetInput"   data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent = "addReview">
                <div class="modal-body">
                    <div class="rating-css">
                        <div class="star-icon">
                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="1" id="rating1">
                            <label for="rating1" class="fa fa-star"></label>
                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="2" id="rating2">
                            <label for="rating2" class="fa fa-star"></label>
                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="3" id="rating3">
                            <label for="rating3" class="fa fa-star"></label>
                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="4" id="rating4">
                            <label for="rating4" class="fa fa-star"></label>
                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="5" id="rating5">
                            <label for="rating5" class="fa fa-star"></label>
                        </div>
                        @error('product_rating')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                        <div>
                            <label>Comment</label>
                            <textarea  class="form-control" wire:model.defer="comment"  rows="3"></textarea>
                            @error('product_rating')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                </div>
                <div class="modal-footer">
                <button type="button" wire:click="resetInput"    class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!--Edit Review Modal -->
    <div wire:ignore.self class="modal fade" id="reviewEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Review {{ $product->name }}</h1>
            <button type="button" class="btn-close" wire:click="resetInput" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="p-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div wire:loading.remove>
                <form wire:submit.prevent = "updateReview">
                    <div class="modal-body">
                            <div class="rating-css">
                                <div class="star-icon">

                                    @for ($i=0; $i < 5; $i++)
                                        @if ($i < $this->product_rating)
                                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="{{ $i+1 }}" id="rating{{$i+1}}">
                                            <label for="rating{{$i+1}}" class="fa fa-star"></label>
                                        @else
                                            <input type="radio" name="product_rating" wire:model.defer="product_rating" value="{{ $i+1 }}" id="rating{{$i+1}}">
                                            <label for="rating{{$i+1}}" class="fa fa-star"></label>
                                        @endif
                                    @endfor
                                </div>
                                    @error('product_rating')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                            <div>
                                <label>Comment</label>
                                <textarea wire:model.defer="comment" class="form-control" rows="3"></textarea>
                                @error('comment')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" wire:click="resetInput"  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border" wire:ignore>
                        @if($product->productImages)
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
                       {{-- Product Rating --}}
                       <div>
                        @php
                                $reviewCount = $reviews->count();
                                $ratingSum = $reviews->sum('rating');
                                if($reviewCount > 0){
                                    $ratingValue = number_format($ratingSum/$reviewCount,1);
                                }else{
                                    $ratingValue = 0 ;
                                }

                                $percent = round($ratingValue * 100/5);
                                if ($percent > 80 && $percent <= 100){
                                    $star = 5;
                                } else if ($percent > 60 && $percent <= 80){
                                    $star = 4;
                                } else if ($percent > 40 && $percent <= 60){
                                    $star = 3;
                                } else if ($percent > 20 && $percent <= 40){
                                    $star = 2;
                                } else if ($percent > 0 && $percent <= 20){
                                    $star = 1;
                                } else {
                                    $star = 0;
                                }
                        @endphp
                        @if ($reviewCount > 0)
                            <span>
                                @for ($i=0;$i<5;$i++)
                                    @if ($i < $star)
                                        <i class="fa fa-star" style="color:gold"></i>
                                    @else
                                        <i class="fa fa-star"></i>
                                    @endif
                                @endfor
                                {{ $reviewCount }} Ratings
                            </span>
                        @endif


                        </div>

                        <div>
                            @if($product->productColors->count() > 0)
                                @if ($product->productColors)
                                    @foreach ($product->productColors as $productColor)

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
                                <span wire:click="decrementQty" class="btn btn1"><i class="bi bi-dash"></i></span>
                                <input type="text" wire:model="qtyCount" readonly value="{{ $this->qtyCount }}" class="input-quantity" />
                                <span wire:click="incrementQty" class="btn btn1"><i class="bi bi-plus"></i></span>
                            </div>
                        </div>
                            <div class="mt-2">
                                <button type="button" wire:click="addToCart({{$product->id}})" class="btn btn1">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-cart-plus-fill"></i>
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
                                        <i class="bi bi-heart-fill"></i>
                                        <span wire:loading.remove wire:target="addToWishList">
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

                                <a  data-bs-toggle="modal" data-bs-target="#reviewModal" class="btn btn-sm btn-warning">Write Review</a>

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
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4>Progress Bar</h4>
                        </div>
                        @php
                            $oneReviewCount = $one->count();
                            $twoReviewCount = $two->count();
                            $threeReviewCount = $three->count();
                            $fourReviewCount = $four->count();
                            $fiveReviewCount = $five->count();

                            $onePercent =  $reviewCount > 0 ?  ($oneReviewCount/$reviewCount)*100 : 0;
                            $twoPercent =  $reviewCount > 0 ?  ($twoReviewCount/$reviewCount)*100 : 0;
                            $threePercent =  $reviewCount > 0 ?  ($threeReviewCount/$reviewCount)*100 : 0;
                            $fourPercent =  $reviewCount > 0 ?  ($fourReviewCount/$reviewCount)*100 : 0;
                            $fivePercent =   $reviewCount > 0 ?  ($fiveReviewCount/$reviewCount)*100 : 0;

                        @endphp
                        <div class="card-body">
                            <div>
                                <h1>{{ $ratingValue }}/5 <i class="bi bi-star-fill" style="color:gold"></i></h1>
                                <h3>Total Ratings - {{ $reviewCount }}</h3>
                            </div>
                            <div>1 <i class="bi bi-star-fill"></i> <span>({{ $oneReviewCount }})</span></div>
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{  $onePercent  }}%" aria-valuenow="{{ $onePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div>2 <i class="bi bi-star-fill"></i> <span>({{ $twoReviewCount }})</span></div>
                              <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ $twoPercent }}%" aria-valuenow="{{ $twoPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div>3 <i class="bi bi-star-fill"></i> <span>({{ $threeReviewCount }})</span></div>
                              <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: {{ $threePercent }}%" aria-valuenow="{{ $threePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div>4 <i class="bi bi-star-fill"></i> <span>({{ $fourReviewCount }})</span></div>
                              <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{ $fourPercent }}%" aria-valuenow="{{ $fourPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>
                              <div>5 <i class="bi bi-star-fill"></i> <span>({{ $fiveReviewCount }})</span></div>
                              <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: {{ $fivePercent }}%" aria-valuenow="{{ $fivePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4>Reviews</h4>
                        </div>
                        <div class="card-body">
                        <div class="row">
                            @forelse ($reviews as $review)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <h6><b>{{ $review->name }}</b></h6>
                                                <h6>{{ $review->updated_at->diffforhumans() }}</h6>
                                            </div>

                                                <div>
                                                    @for ($i=0; $i < 5 ;$i++)
                                                        @if ($i < $review->rating)
                                                            <i class="fa fa-star" style="color:gold"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>

                                                        @endif
                                                    @endfor
                                                </div>

                                            <p>{{ $review->comment }}</p>
                                            <div>
                                                @if (Auth::check())
                                                    @if($review->user_id == Auth::user()->id)
                                                    <a wire:click="editReview({{$review->id}})" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reviewEditModal">Edit</a>
                                                    <a wire:click="deleteReview({{$review->id}})" class="btn btn-sm btn-danger">Delete</a>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p>No reviews</p>
                                </div>
                            @endforelse

                        </div>

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

    <script>

        window.addEventListener('close-modal', event => {
            $("#reviewModal").modal('hide');
            $("#reviewEditModal").modal('hide');

        })

    </script>






@endpush

