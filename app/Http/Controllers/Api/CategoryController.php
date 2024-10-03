<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function index(){
        $categories = Category::latest()->paginate(5);

        return new CategoryResource(true, 'List Data Category', $categories);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'kategori' => 'required',
            'slug' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $category = Category::create([
            'kategori'=>$request->kategori,
            'slug' => $request->slug,
        ]);

        return new CategoryResource(true, 'Data Category Berhasil Ditambahkan !', $category);
    }

    public function show($id){
        $category = Category::find($id);

        return new CategoryResource(true, 'Detail Data Category', $category);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'kategori' => 'required',
            'slug' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }

        $category = Category::find($id);
        $category->update([
            'kategori'=>$request->kategori,
            'slug' => $request->slug,
        ]);

        return new CategoryResource(true, 'Data Category berhasil Diubah !', $category);
    }
    
    public function destroy($id){
        $category = Category::find($id);

        $category->delete();
        return new CategoryResource(true, 'Data Berhasil Dihapus', null);
    
    }
}
