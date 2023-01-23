<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test (){
        // $today = date('Y-m-d');
        // $from = date('Y-m-d',strtotime('+1day'.$today));
        // $to = date('Y-m-d',strtotime('-2day'.$today));

        // $order = Order::where('created_at','<',$from)->where('created_at','>=',$to)->get();


        $order = DB::table('order_items')
    ->groupBy('product_id')
    ->having(DB::raw('sum(quantity)'), '>', 3)
    ->get();

    // $orders = DB::table('order_items')
    //             ->groupBy('product_id')
    //             ->havingRaw('SUM(quantity) > ?', [3])
    //             ->get();

                dd($order);

    }
}
