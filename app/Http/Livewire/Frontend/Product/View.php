<?php

namespace App\Http\Livewire\Frontend\Product;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Review;
use Livewire\Component;
use App\Models\WishList;
use Illuminate\Support\Facades\Auth;

class View extends Component
{
    public $product,$category,$productColorSelectedQty,$qtyCount = 1,$productColorId,$product_rating,$comment,$reviews,$one,$two,$three,$four,$five,$review_id;


    public function colorSelected($productColorId){
        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id',$productColorId)->first();
        $this->productColorSelectedQty = $productColor->quantity;
        if($this->productColorSelectedQty == 0){
            $this->productColorSelectedQty = 'outOfStock';
        }
    }

    public function addToWishList($productId){

        if(Auth::check()){
            if(WishList::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists()){
                session()->flash('message','Wishlist added already');
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Wishlist added already',
                    'type' => 'warning',
                    'status' => 409
                ]);
                return false;
            }else{
                WishList::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                $this->emit('wishlistAddedUpdated');
                session()->flash('message','Product added to wishlist successfully');
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Product added to wishlist successfully',
                    'type' => 'success',
                    'status' => 200
                ]);
            }

        }else{
            session()->flash('message','Please log in to continue');
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please log in to continue',
                'type' => 'info',
                'status' => 401
            ]);
            return false;
        }
    }

    public function incrementQty(){
        if($this->qtyCount < 10){
            $this->qtyCount++;
        }

    }

    public function decrementQty(){
        if($this->qtyCount > 1)
        $this->qtyCount--;
    }

    public function addToCart($productId){
        if(Auth::check())
        {
            if($this->product->where('id',$productId)->where('status','0')->exists())
            {

                if($this->product->productColors()->count()>0)
                {
                    if($this->productColorSelectedQty != null)
                    {
                        $productColor = $this->product->productColors()->where('id',$this->productColorId)->first();

                        if(Cart::where('user_id',auth()->user()->id)->where('product_id',$productId)->where('product_color_id',$this->productColorId)->exists())
                        {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Product with such color added to cart already',
                                'type' => 'warning',
                                'status' => 404
                            ]);


                        }
                        else
                        {
                            if($productColor->quantity > 0)
                            {
                                if($productColor->quantity >= $this->qtyCount)
                                {
                                    Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'quantity' => $this->qtyCount
                                    ]);
                                    $this->emit('cartAddedUpdated');

                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Added to cart successfully',
                                        'type' => 'success',
                                        'status' => 200
                                    ]);
                                }
                                else
                                {
                                    $this->dispatchBrowserEvent('message', [
                                        'text' => 'Only '.$productColor->quantity.' quantity available',
                                        'type' => 'warning',
                                        'status' => 400
                                    ]);
                                }

                            }
                            else
                            {
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Out of stock',
                                    'type' => 'warning',
                                    'status' => 400
                                ]);
                            }
                        }


                    }
                    else
                    {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Please select product color',
                            'type' => 'info',
                            'status' => 404
                        ]);
                    }
                }
                else
                {
                    if(Cart::where('user_id',auth()->user()->id)->where('product_id',$productId)->exists())
                    {
                        $this->dispatchBrowserEvent('message', [
                            'text' => 'Product added to cart already',
                            'type' => 'info',
                            'status' => 404
                        ]);
                    }
                    else
                    {
                        if($this->product->quantity > 0)
                        {
                            if($this->product->quantity >= $this->qtyCount)
                            {

                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' => $this->qtyCount
                                ]);
                                $this->emit('cartAddedUpdated');
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Added to cart successfully',
                                    'type' => 'success',
                                    'status' => 200
                                ]);
                            }
                            else
                            {
                                $this->dispatchBrowserEvent('message', [
                                    'text' => 'Only '.$this->product->quantity.' quantity available',
                                    'type' => 'warning',
                                    'status' => 404
                                ]);
                            }
                        }
                        else
                        {
                            $this->dispatchBrowserEvent('message', [
                                'text' => 'Out of stock',
                                'type' => 'warning',
                                'status' => 404
                            ]);
                        }
                    }
                }
            }
            else
            {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Product does not exist',
                    'type' => 'warning',
                    'status' => 404
                ]);
            }
        }
        else
        {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please log in to add to cart',
                'type' => 'warning',
                'status' => 401
            ]);
        }
    }

    public function addReview(){
        $this->validate([
            'product_rating' => 'required',
            'comment' => 'required'
        ]);
        if(Auth::check()){
            $verified_purchase = Order::where('orders.user_id',Auth::user()->id)
                ->where('orders.status_message','completed')
                ->join('order_items','orders.id','order_items.order_id')
                ->where('order_items.product_id',$this->product->id)
                ->exists();

            if($verified_purchase){
                if(Review::where('user_id',Auth::user()->id)->where('product_id',$this->product->id)->exists()){
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'You reviewed this product already',
                        'type' => 'warning',
                        'status' => 500
                    ]);
                }else{
                    Review::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $this->product->id,
                        'rating' => $this->product_rating,
                        'comment' => $this->comment
                    ]);
                    $this->dispatchBrowserEvent('message', [
                        'text' => 'You reviewed this product successfully',
                        'type' => 'success',
                        'status' => 200
                    ]);
                    $this->dispatchBrowserEvent('close-modal');
                    $this->resetInput();

                }
            }else{
                $this->dispatchBrowserEvent('message', [
                    'text' => 'You cannot review this product without purchasing',
                    'type' => 'warning',
                    'status' => 500
                ]);
            }
        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please log in to continue',
                'type' => 'warning',
                'status' => 401
            ]);
        }

    }

    public function editReview(int $review_id){
        $this->review_id = $review_id;
        $review = $this->product->reviews()->where('id',$review_id)->first();
        $this->product_rating = $review->rating;
        $this->comment = $review->comment;
    }

    public function updateReview(){
        $this->validate([
            'product_rating' => 'required',
            'comment' => 'required'
        ]);

        $review = $this->product->reviews()->where('id',$this->review_id)->first();
        if($review){
            $review->update([
                'rating' => $this->product_rating,
                'comment' => $this->comment
            ]);
            $this->dispatchBrowserEvent('message', [
                'text' => 'You edited review successfully',
                'type' => 'success',
                'status' => 200
            ]);
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInput();
        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Review not exists',
                'type' => 'error',
                'status' => 400
            ]);
        }

    }

    public function deleteReview(int $review_id){
        Review::findOrFail($review_id)->delete();
        $this->dispatchBrowserEvent('message', [
            'text' => 'Review deleted successfully',
            'type' => 'success',
            'status' => 200
        ]);
    }

    public function resetInput(){
        $this->comment = '';
        $this->resetErrorBag();
    }

    public function mount($product,$category){
        $this->product = $product;
        $this->category = $category;

    }
    public function render()
    {
        $this->reviews = Review::where('product_id',$this->product->id)->get();
        $this->one = Review::where('product_id',$this->product->id)->where('rating',1)->get();
        $this->two = Review::where('product_id',$this->product->id)->where('rating',2)->get();
        $this->three = Review::where('product_id',$this->product->id)->where('rating',3)->get();
        $this->four = Review::where('product_id',$this->product->id)->where('rating',4)->get();
        $this->five = Review::where('product_id',$this->product->id)->where('rating',5)->get();

        return view('livewire.frontend.product.view',[
            'product' => $this->product,
            'category' => $this->category,
            'reviews' => $this->reviews,
            'one' => $this->one,
            'two' => $this->two,
            'three' => $this->three,
            'four' => $this->four,
            'five' => $this->five,
        ]);
    }
}
