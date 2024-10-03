<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CheckoutResource;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    //
    public function index(){
        $checkouts=Checkout::latest()->paginate(15);

        return new CheckoutResource(true, 'List Data Checkouts', $checkouts);
    }

    public function show($id){
        $checkout=Checkout::find($id);

        return new CheckoutResource(true, 'Detail Data Checkout', $checkout);
    }

    public function destroy($id){
        $checkout=Checkout::find($id);

        $checkout->delete();
        return new CheckoutResource(true, 'Data Berhasil Dihapus !', null);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'no_order'=>'required',
            'total_harga'=>'required',
            'total_qty'=>'required',
            'snap_token'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $checkout = Checkout::create([
            'no_order'=>$request->no_order,
            'total_harga'=>$request->total_harga,
            'total_qty'=>$request->total_qty,
            'snap_token'=>$request->snap_token
        ]);

        return new CheckoutResource(true, 'Data Checkout Berhasil Ditambahkan !', $checkout);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'no_order'=>'required',
            'total_harga'=>'required',
            'total_qty'=>'required',
            'snap_token'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $checkout = Checkout::find($id);

        $checkout->update([
            'no_order'=>$request->no_order,
            'total_qty'=>$request->total_qty,
            'total_harga'=>$request->total_harga,
            'snap_token'=>$request->snap_token
        ]);

        return new CheckoutResource(true, 'Data Checkout Berhasil Diubah !', $checkout);
    }
}
