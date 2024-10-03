<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function index(){
        $customers = Customer::latest()->paginate(15);

        return new CustomerResource(true, 'List Data Customer', $customers);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'nama'=>'required',
            'email'=>'required|email',
            'telp'=>'required',
            'alamat'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $customer=Customer::create([
            'nama'=>$request->nama,
            'email'=>$request->email,
            'telp'=>$request->telp,
            'alamat'=>$request->alamat
        ]);

        return new CustomerResource(true, 'Data Customer Berhasil Ditambahkan', $customer);
    }

    public function show($id){
        $customer = Customer::find($id);


        return new CustomerResource(true, 'Detail Data Customer',$customer);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'nama'=>'required',
            'email'=>'required|email',
            'telp'=>'required',
            'alamat'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $customer=Customer::find($id);

        $customer->update([
            'nama'=>$request->nama,
            'email'=>$request->email,
            'telp'=>$request->telp,
            'alamat'=>$request->alamat
        ]);

        return new CustomerResource(true, 'Data Berhasil Diubah !', $customer);
    }

    public function destroy($id){
        $customer = Customer::find($id);

        $customer->delete();
        return new CustomerResource(true, 'Data Berhasil Dihapus', null);
    }
}
