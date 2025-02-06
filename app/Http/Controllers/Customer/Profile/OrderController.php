<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (isset(request()->type)) {
            $orders = Auth::user()->orders()->where('order_status', request()->type)->orderBy('created_at', 'desc')->get();
        }
        else {
            $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();
        }

//        $image_orders = [];
//        foreach ($orders as $order) {
//            $image_order = OrderItem::where('order_id', $order->id)->orderBy('created_at', 'desc')->get();
//            array_push($image_orders, $image_order);
//
//        }
//        foreach ($image_orders as $image_order) {
//            dd($image_order->product);
//        }
////        dd($image_orders);
        return view('customer.profile.orders', compact('orders'));

    }
}
