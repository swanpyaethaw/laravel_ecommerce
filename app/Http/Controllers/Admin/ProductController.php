<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductFormRequest;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('admin.products.index',compact('products'));
    }

    public function create(){
        $colors = Color::where('status','0')->get();
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create',compact('categories','brands','colors'));
    }

    public function store(ProductFormRequest $request){
        $validated = $request->validated();

        $category = Category::findOrFail($validated['category_id']);
        $product = $category->products()->create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'brand' => $validated['brand'],
            'small_description' => $validated['small_description'],
            'description' => $validated['description'],
            'meta_title' => $validated['meta_title'],
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'original_price' => $validated['original_price'],
            'selling_price' => $validated['selling_price'],
            'quantity' => $validated['quantity'],
            'trending' => $request->trend == true ? '1' : '0',
            'status' => $request->status == true ? '1' : '0'
        ]);

        $uploadPath = 'uploads/products/';
        if($request->hasFile('image')){

            foreach($request->file('image') as $fileImage){
                $ext = $fileImage->getClientOriginalExtension();
                $fileName = uniqid().'.'.$ext;
                $fileImage->move($uploadPath,$fileName);
                $finalPathImageName = $uploadPath.$fileName;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalPathImageName
                ]);
            }
        }

        if($request->colors){
            foreach($request->colors as $key=>$color){
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->color_quantity[$key] ?? 0
                ]);
            }
        }
        return redirect('admin/products')->with('message','Product Created Successfully');
    }



    public function edit(int $product_id){
        $product = Product::findOrFail($product_id);
        $categories = Category::all();
        $brands = Brand::all();
        $product_colors = $product->productColors->pluck('color_id')->toArray();
        $colors = Color::whereNotIn('id',$product_colors)->get();


        return view('admin.products.edit',compact('product','categories','brands','colors'));
    }

    public function update(ProductFormRequest $request,int $product_id){

        $validated = $request->validated();

        $product = Category::findOrFail($validated['category_id'])->products()->where('id',$product_id)->first();


        if($product){
            $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'brand' => $validated['brand'],
            'small_description' => $validated['small_description'],
            'description' => $validated['description'],
            'meta_title' => $validated['meta_title'],
            'meta_keyword' => $validated['meta_keyword'],
            'meta_description' => $validated['meta_description'],
            'original_price' => $validated['original_price'],
            'selling_price' => $validated['selling_price'],
            'quantity' => $validated['quantity'],
            'trending' => $request->trend == true ? '1' : '0',
            'status' => $request->status == true ? '1' : '0'
            ]);

            $uploadPath = 'uploads/products/';
            if($request->hasFile('image')){
            foreach($request->file('image') as $fileImage){
                $ext = $fileImage->getClientOriginalExtension();
                $fileName = uniqid().'.'.$ext;
                $fileImage->move($uploadPath,$fileName);
                $finalPathImageName = $uploadPath.$fileName;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalPathImageName
                ]);
            }
        }

        if($request->colors){
            foreach($request->colors as $key=>$color){
                $product->productColors()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'quantity' => $request->color_quantity[$key] ?? 0
                ]);
            }
        }

            return redirect('admin/products')->with('message','Product Updated Successfully');
        }else{
            return redirect('admin/products')->with('message','No Product with such id');
        }
    }



    public function destroyImage(int $product_image_id){
        $product_image = ProductImage::findOrFail($product_image_id);

        if(File::exists($product_image->image)){
            File::delete($product_image->image);
        }

        $product_image->delete();
        return redirect()->back()->with('message','Image Deleted');

    }



    public function destroy(int $product_id){
        $product = Product::findOrFail($product_id);
        if($product->productImages){
            foreach($product->productImages as $image){
                if(File::exists($image->image)){
                    File::delete($image->image);
                }
            }
        }
        $product->delete();
        return redirect('admin/products')->with('message','Product Deleted');
    }

    public function updateProductColorQty(Request $request,$product_color_id){
        $product_color = Product::findOrFail($request->product_id)->productColors()->where('id',$product_color_id)->first();

        $product_color->update([
            'quantity' => $request->qty
        ]);

        return response()->json(['message'=>'Product Color Qty Updated']);
    }


    public function destroyProductColor($product_color_id){
        $productColor = ProductColor::findOrFail($product_color_id);
        $productColor->delete();
        return response()->json(['message'=>'Product Color Deleted']);
    }


}
