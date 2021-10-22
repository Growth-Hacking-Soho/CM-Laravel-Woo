<?php

namespace App\Http\Controllers;

use App\Mail\ThanksMail;
use App\Models\Gift;
use Carbon\Carbon;
use Codexshaper\WooCommerce\Facades\WooCommerce;
use Codexshaper\WooCommerce\Models\Order;
use Crypt;
use DebugBar\DebugBar;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mail;
use stdClass;
use Storage;
use Str;
use Vimeo\Laravel\Facades\Vimeo;


class GiftController extends Controller
{

    public function show($id)
    {
        $order = null;
        try {
            $order = WooCommerce::all('orders/'.$id);
            app('debugbar')->debug($order);
        }
        catch (Exception $e) {
        }

        if ($order == null)
            return view('customer.gifts.error');

        $order_id = Crypt::encryptString($id);

        return view('customer.gifts.form')
            ->with(['order_id' => $order_id, 'option' => false]);
    }

    public function showUpdate($key)
    {
        $gift = Gift::where('key','=', $key)->get()->first();
        if ($gift == null){
            return view('customer.gifts.error');
        }

        app('debugbar')->debug($gift);

        $model = new \stdClass();
        $model->name = $gift->name;
        $model->message = $gift->message;
        $model->email = $gift->email;
        $model->phone = $gift->phone;
        $model->key = $gift->key;

        return view('customer.gifts.form')
            ->with(['model' => $model, 'option' => true]);
    }

    public function data(Request $request) : JsonResponse
    {
        $request->validate([
            'columns' => ['required']
        ]);

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;
        $search = $request->search;
        //$draw = $request->draw;
        $order = $request->order;
        //$filter = $request->filter;

        $orderField = "id";
        $orderDirection = "desc";
        if ($order != null && count($order) > 0) {
            $orderDirection = $order[0]["dir"];
            switch ($order[0]["column"]) {
                case 1:
                    $orderField = 'name';
                    break;
                default:
                    break;
            }
        }

        $rows = DB::table('gifts')
            ->orderByRaw($orderField . ' ' . $orderDirection)
            ->skip($start)
            ->take($length);

        $criteria = "";
        if ($search != null) {
            $criteria = $search["value"];
            if ($criteria != null && $criteria !== "") {
                $rows = $rows
                    ->where('name', 'like', '%' . $criteria . '%');
            }
        }

        $data = $rows->get();
        $total = DB::table('gifts')->count();
        $isFiltered = $criteria != null && $criteria !== "";
        $sTotal = $isFiltered ? $data->count() : $total;

        $result = new stdClass();

        $result->iTotalRecords = $total;
        $result->iTotalDisplayRecords = $sTotal;
        $result->aaData = $data;

        return response()->json($result);

    }

    public function store(Request $request)
    {
        try{
            $request->validate([
               'order_id',
               'file_name'
            ]);

        $order_id = Crypt::decryptString($request->order_id);

        $order = WooCommerce::all('orders/'.$order_id);
        if($order == null)
            throw new Exception('No se encontro la orden');

        $order_email = $order->billing->email;

        $sku = $order->line_items[0]->sku;

        //TODO: Validar la existencia del SKU que viene de woocomerce
        //if($sku == null)
        //    throw new Exception('No se encontro la botella');

        $gift = new Gift;
        $gift->key = Str::uuid();
        $gift->order_id = $order_id;
        $gift->sku = $sku;
        $gift->order_email = $order_email;
        $gift->email = $request->email;
        $gift->phone = $request->phone;
        $gift->name = $request->name;
        $gift->message = $request->message;
        $gift->status = 'send';
        $gift->video = $request->video;
        $gift->save();

        $file = $request->file('video');
        if ($file !== null) {

            //https://www.getid3.org/
            //$metadata = exif_read_data('C:\Users\osdei\source\repos\laravel-woocommerce\storage\app\public\videos\c8c5969c-29f8-4548-a6f4-f334bdf51a99.mp4');

            $fileName = "videos/".$gift->key.'.mp4';
            Storage::disk('public')->put($fileName, file_get_contents($file));
            $fullFileName = Storage::path($fileName);

            app('debugbar')->debug($fileName);
            app('debugbar')->debug($fullFileName);
            //Vimeo::upload($fullFileName);
        }

        //TODO: DoMail (2)
        //Mail::to("jspinzonr@gmail.com")->send(new ThanksMail($gift));

        //return view('customer.gifts.send');
        return redirect()->route('gift.preview', $gift->key);

        }
        catch(Exception $ex){
            debugbar()->addThrowable($ex);
            $error = [
                'title'=> $ex->getMessage(),
                'icon'=> 'error',
            ];
            return view('customer.gifts.form')
                ->with('order_id', $request->order_id)
                ->with('toast', $error);
        }
    }

    public function update(Request $request, $key) {
        app('debugbar')->debug("Probando $key");
        //$request->session()->flush();
        $gift = Gift::where('key', $key)->first();
        /* if ($gift == null){
            $resultado = [
                'title'=> 'No se encontro el regalo',
                'icon'=> 'error',
            ];
            $request->session()->flash('toast', $resultado);
            return view('customer.gifts.error');
        } */

        $gift->name = $request->name;
        $gift->email = $request->email;
        $gift->phone = $request->phone;
        $gift->message = $request->message;

        $file = $request->file('video');
        if ($file !== null) {
            $gift->video = $request->video;

            $fileName = "videos/".$gift->key.'.mp4';
            //TODO: Eliminar video actual, para poder guardar nuevo video
            Storage::disk('public')->delete($fileName);

            Storage::disk('public')->put($fileName, file_get_contents($file));
            $fullFileName = Storage::path($fileName);

            app('debugbar')->debug($fileName);
            app('debugbar')->debug($fullFileName);
            //Vimeo::upload($fullFileName);
        }

        $gift->save();

        return redirect()->route('gift.preview', $key);
    }

    public function play($key, Request $request)
    {
        $request->session()->flush();
        $gift = Gift::where('key','=', $key)->get()->first();
        if ($gift == null){
            $resultado = [
                'title'=> 'No se encontro el regalo',
                'icon'=> 'error',
            ];
            $request->session()->flash('toast', $resultado);
            return view('customer.gifts.error');
        }

        $order = WooCommerce::all('orders/' . $gift->order_id);
        if ($order == null){
            $resultado = [
                'title'=> 'No se encontro la orden',
                'icon'=> 'error',
            ];
            $request->session()->flash('toast', $resultado);
            return view('customer.gifts.error');
        }

        $product_id = $order->line_items[0]->product_id;

        $product = WooCommerce::find('products/' . $product_id);
        if ($product == null) {
            $resultado = [
                'title'=> 'No se encontro el producto',
                'icon'=> 'error',
            ];
            $request->session()->flash('toast', $resultado);
            return view('customer.gifts.error');
        }

        app('debugbar')->debug($product);
        app('debugbar')->debug($gift);
        app('debugbar')->debug($order);

        $model = new \stdClass();
        $model->name = $gift->name;
        $model->message = $gift->message;
        $model->status = $order->status;
        $model->description = $product->description;
        $model->images = $product->images;
        $model->video = $gift->video;
        $model->key = $gift->key;

        app('debugbar')->debug($model);

        $gift->counter = $gift->counter+1;
        $gift->last_open_at = Carbon::now();
        if ($gift->first_open_at == null)
            $gift->first_open_at = $gift->last_open_at;
        $gift->save();

        return view('customer.gifts.video')
            ->with('model', $model);
    }

    public function preview($key, Request $request)
    {
        $request->session()->flush();
        $gift = Gift::where('key','=', $key)->get()->first();
        if ($gift == null){
            $resultado = [
                'title'=> 'No se encontro el regalo',
                'icon'=> 'error',
            ];
            $request->session()->flash('toast', $resultado);
            return view('customer.gifts.error');
        }

        app('debugbar')->debug($gift);

        $model = new \stdClass();
        $model->name = $gift->name;
        $model->message = $gift->message;
        $model->video = $gift->video;
        $model->key = $gift->key;

        app('debugbar')->debug($model);

        return view('customer.gifts.preview')
            ->with('model', $model);
    }

    public function video($id){

        $path = storage_path('app/public/videos/'.$id.'.mp4');

        if (!File::exists($path)) {
            abort(404);
        }

        $stream = new \App\Http\VideoStream($path);

        return response()->stream(function() use ($stream) {
            $stream->start();
        });
    }

}
