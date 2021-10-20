<?php

namespace App\Http\Controllers;

use Codexshaper\WooCommerce\Facades\WooCommerce;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function debug()
    {
        $orders = WooCommerce::all('orders');
        app('debugbar')->debug($orders);
        return view('admin.debug')
            ->with('orders', $orders);
    }
}
