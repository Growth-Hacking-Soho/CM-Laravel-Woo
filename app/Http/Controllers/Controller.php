<?php

namespace App\Http\Controllers;

//use Codexshaper\WooCommerce\Facades\WooCommerce;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

//    public function products()
//    {
//        $products =  WooCommerce::all('products');
//        $orders = WooCommerce::all('orders');
//        return view("Products")
//            ->with('products',$products)
//            ->with('orders',$orders);
//    }
//
//    public function product( Request $request )
//    {
//        $product = WooCommerce::find('products/'.$request->id);
//    }
//
//    public function orders()
//    {
//        return WooCommerce::all('orders');
//    }
//
//    public function order( Request $request )
//    {
//        $order = WooCommerce::all('orders/'.$request->id);
//    }
//
//    public function customers()
//    {
//        return WooCommerce::all('customers');
//    }
//
//    public function customer( Request $request )
//    {
//        $customer = WooCommerce::all('customers/'.$request->id);
//    }
}
