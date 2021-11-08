<?php

namespace App\Console\Commands;

use App\Mail\UrlMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Codexshaper\WooCommerce\Facades\WooCommerce;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //\Log::info("Cron is working fine!");
        $orders = null;
        try {
            $sku = 'gift-box-primary';
            $orders = WooCommerce::all('orders');
            $orders = collect($orders)->filter(function($value) use ($sku) {
                if (count($value->line_items) > 0) {
                    if ($value->line_items[0]->sku === $sku) {
                        return true;
                    }
                }
            })->all();
            foreach ($orders as $order) {
                $order_search = Order::find($order->id);
                if ($order_search) {
                    if ($order_search->status == 'completed') {
                        if (!$order_search->send) {
                            Mail::to("jspinzonr@gmail.com")->send(new UrlMail($order->id));
                            $order_search->send = true;
                            $order_search->save();
                        }
                    } else {
                        $order_search->status = $order->status;
                        $order_search->save();
                    }
                } else {
                    $data['order_id'] = $order->id;
                    $data['status'] = $order->status;
                    $data['send'] = false;
                    $new_order = Order::create($data);
                    DB::commit();
                    $new_order->save();
                }
            }
        }
        catch (Exception $e) {
            \Log::error($e);
        }
    }
}
