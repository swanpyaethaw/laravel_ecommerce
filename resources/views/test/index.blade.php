@extends('layouts.admin')

@section('content')



    <div class="row">
        <div class="col-md-12">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>
                        Back
                        <a href="{{ url('admin/products/') }}" class="btn btn-sm btn-primary float-end">Back</a>
                    </h3>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-tab-pane" type="button" role="tab" aria-controls="seo-tab-pane" aria-selected="false">SEO tags</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="false">Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="false">Product Images</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="color-tab" data-bs-toggle="tab" data-bs-target="#color-tab-pane" type="button" role="tab" aria-controls="color-tab-pane" aria-selected="false">Product Colors</button>
                        </li>

                      </ul>
                      <form action="{{ url('admin/products/'.$product->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                      <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                <div class="mb-3">
                                    <label>Select Category</label>
                                    <select name="category_id" class="form-control" style="width:150px">
                                        @forelse ($categories as $category)
                                        <option value="{{ $category->id }}" {{$category->id == $product->category_id ? 'selected' : ''}} >{{ $category->name }}
                                        </option>
                                        @empty
                                        No Category Found
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Product Slug</label>
                                <input type="text" name="slug" value="{{ $product->slug }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Select Brand</label>
                                <select name="brand" class="form-control" style="width:150px">
                                    @forelse ($brands as $brand)
                                    <option value="{{ $brand->name }}" {{$brand->name == $product->brand ? 'selected' : ''}}>{{ $brand->name }}</option>
                                    @empty
                                    No Brand Found
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Small Description</label>
                                <textarea name="small_description" class="form-control" rows="4">{{ $product->small_description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade border p-3" id="seo-tab-pane" role="tabpanel" aria-labelledby="seo-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" value="{{ $product->meta_title }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Meta Keyword</label>
                                <textarea name="meta_keyword" class="form-control" rows="4">{{ $product->meta_keyword }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="4">{{ $product->meta_description }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade border p-3" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Original Price</label>
                                    <input type="text" name="original_price" value="{{ $product->original_price }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Selling Price</label>
                                    <input type="text" name="selling_price" value="{{ $product->selling_price }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Trend</label>
                                    <input type="checkbox" name="trending" {{ $product->trending == '1' ? 'checked' : '' }}> Checked = Trending/Unchecked = Not Trending
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <input type="checkbox" name="status" {{ $product->status == '1' ? 'checked' : '' }}> Checked = Hidden/Unchecked = Visible
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Upload Product Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                            </div>
                            @if($product->productImages)
                                <div class="row">
                                    @foreach ($product->productImages as $image)
                                        <div class="col-md-2 border me-2 p-2">
                                            <img src="{{ asset($image->image) }}" alt="" style="width:50px;height:50px"><br>
                                            <a href="{{ url('admin/product-image/'.$image->id.'/delete') }}">Remove</a>
                                        </div>

                                    @endforeach
                                </div>

                            @else
                            No image added
                            @endif
                        </div>
                        <div class="tab-pane fade border p-3" id="color-tab-pane" role="tabpanel" aria-labelledby="color-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Select Product Color</label><br>
                                <div class="row">
                                    @forelse ($colors as $color)
                                    <div class="col-md-2 border p-2 me-2">
                                        Color: <input type="checkbox" value="{{ $color->id }}" name="colors[{{ $color->id }}]"> {{ $color->name }}<br>
                                        Quantity: <input type="number" name="color_quantity[{{ $color->id }}]" style="width:70px;border:1px solid">
                                    </div>
                                @empty
                                    No color added
                                @endforelse
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Color Name</th>
                                                <th>Quantity</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->productColors as $productColor)
                                                <tr class="product-color-tr">
                                                    <td>
                                                        @if($productColor->color)
                                                            {{ $productColor->color->name }}
                                                        @else
                                                            No Color
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="text" value="{{ $productColor->quantity }}" style="width:70px;" class="productColorQty">
                                                        <button value="{{ $productColor->id }}" type="button" class="updateProductColor btn btn-primary btn-sm">Update</button>
                                                    </td>
                                                    <td>
                                                        <button type="button" value="{{ $productColor->id }}" class="deleteProductColor btn btn-danger btn-sm">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>


                            </div>
                        </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>

                      </div>
                </div>
            </div>


@endsection

@section('scripts')
    <script>

        let updateBtn = document.querySelectorAll('.updateProductColor')
        updateBtn.forEach((btn) =>{
            btn.addEventListener("click",function(e){
                let productColorId = e.target.value
                let qty = e.target.closest('.product-color-tr').querySelector('.productColorQty').value
                let productId = "{{ $product->id }}"

                if(qty <= 0){
                    alert('Qty is required')
                    return false
                }
                axios.post('/admin/product-color/'+productColorId,{
                    productId : productId,
                    qty : qty
                })
                     .then(response => {
                        alert(response.data.message)
                     })
                     .catch(error => {
                        console.log(error)
                     })

            })
        })

        let deleteBtn = document.querySelectorAll('.deleteProductColor')
        deleteBtn.forEach((btn)=>{
            btn.addEventListener("click",function(e){
                let productColorId = e.target.value
                axios.delete('/admin/product-color/'+productColorId+'/delete')
                    .then(response=>{
                        alert(response.data.message)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
            })
        })
    </script>
@endsection
