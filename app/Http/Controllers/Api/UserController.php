<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::get();

        return new UserResource(true, 'List Users', $users);
    }

    public function show($id){
        $user =  User::find($id);

        return new UserResource(true, 'Detail User', $user);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return new UserResource(true, 'User Baru Berhasil Ditambahkan !', $user);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $user=User::find($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return new UserResource(true,' Data Berhasil Diubah !', $user);
    }

    public function destroy($id){
        $user = User::find($id);

        $user->delete();

        return new UserResource(true, 'Data Berhasil Dihapus', null);
    }
}
