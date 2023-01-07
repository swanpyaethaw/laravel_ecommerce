<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Mail\PlaceOrderMailable;
use Illuminate\Support\Facades\Mail;

class CheckoutShow extends Component
{
    public $carts;
    public $totalProductAmount;
    public $fullname,$email,$phone,$pincode,$address,$paymentMode = null,$paymentId = null;

    public function totalProductAmount(){
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id',auth()->user()->id)->get();
        foreach($this->carts as $cartItem){
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }
        return $this->totalProductAmount;

    }

    protected function rules(){
        return [
            'fullname' => 'required|string|max:121',
            'phone' => 'required|numeric|min_digits:11|max_digits:11',
            'email' => 'required|email',
            'pincode' => 'required|numeric|min_digits:6|max_digits:6',
            'address' => 'required|string|max:500'
        ];
    }

    public function placeOrder()
    {
        $this->validate();
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'tracking_no' => 'funda-'.Str::random(10),
            'full_name' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'pincode' => $this->pincode,
            'address' => $this->address,
            'status_message' => 'in progress',
            'payment_mode' => $this->paymentMode,
            'payment_id' => $this->paymentId

        ]);

            foreach($this->carts as $cartItem){
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_color_id' => $cartItem->product_color_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->selling_price
                ]);

                if($cartItem->product_color_id != null){
                    $cartItem->productColor()->where('id',$cartItem->product_color_id)->decrement('quantity',$cartItem->quantity);
                }else{
                    $cartItem->product()->where('id',$cartItem->product_id)->decrement('quantity',$cartItem->quantity);
                }
            }

            return $order;

    }

    public function codOrder()
    {
        $this->paymentMode = 'Cash on Delivery';
        $order = $this->placeOrder();
        if($order){
            Cart::where('user_id',auth()->user()->id)->delete();

            try{
                $order = Order::findOrFail($order->id);
                Mail::to("aungchanmyaethaw0610@gmail.com")->send(new PlaceOrderMailable($order));
            }catch(\Exception $e){

            }
            $this->dispatchBrowserEvent('message', [
                'text' => 'Order placed successfully',
                'type' => 'success',
                'status' => 200
            ]);
            session()->flash('message','Order placed successfully');
            return redirect('thank-you');

        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Something went wrong',
                'type' => 'error',
                'status' => 500
            ]);
        }

    }

    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->phone = auth()->user()->userDetail->phone ?? '';
        $this->address = auth()->user()->userDetail->address ?? '';
        $this->pincode = auth()->user()->userDetail->pin_code ?? '';
        $this->totalProductAmount = $this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show',[
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}
