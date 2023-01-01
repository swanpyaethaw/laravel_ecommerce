<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('user_id',auth()->user()->id)->orderBy('id','desc')->paginate(10);
        return view('frontend.orders.index',compact('orders'));
    }

    public function show($orderId){
        $order = Order::where('user_id',auth()->user()->id)->where('id',$orderId)->first();
        if($order){
            return view('frontend.orders.view',compact('order'));
        }else{
            return redirect('orders')->with('message','Order with such id Not Found');
        }
    }
}
