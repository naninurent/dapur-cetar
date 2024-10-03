<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    public function index(){
        $orders = Order::latest()->paginate(10);

        return new OrderResource(true, 'List Data Orders', $orders);
    }

    public function show($id){
        $order = Order::find($id);

        return new OrderResource(true, 'Detail Data Order', $order);
    }

    public function destroy($id){
        $order =Order::find($id);

        $order->delete();
        return new OrderResource(true,'Data Berhasil Dihapus !', null);
    }

    public function store(Request $request){



        $validator = Validator::make($request->all(),[
            'id_produk'=>'required',
            'id_pelanggan'=>'required',
            'no_order'=>'required',
            'qty'=>'required',
            'sub_total'=>'required',
            'status'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $order = Order::create([
            'id_produk'=>$request->id_produk,
            'id_pelanggan'=>$request->id_pelanggan,
            'no_order'=>$request->no_order,
            'qty'=>$request->qty,
            'sub_total'=>$request->sub_total,
            'status'=>$request->status,
        ]);

        return new OrderResource(true, 'Data Order Berhasil Ditambahkan !', $order);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'id_produk'=>'required',
            'id_pelanggan'=>'required',
            'no_order'=>'required',
            'qty'=>'required',
            'sub_total'=>'required',
            'status'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $order= Order::find($id);

        $order->update([
            'id_produk'=>$request->id_produk,
            'id_pelanggan'=>$request->id_pelanggan,
            'no_order'=>$request->no_order,
            'qty'=>$request->qty,
            'sub_total'=>$request->sub_total,
            'status'=>$request->status,
        ]);

        return new OrderResource(true, 'Data Order Berhasil Ditambahkan !', $order);
    }
    
}
