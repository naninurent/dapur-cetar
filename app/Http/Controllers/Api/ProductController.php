<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::latest()->paginate(5);

        //return collection of products as a resource
        return new ProductResource(true, 'List Data Product', $products);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'ukuran' => 'required',
            'harga' => 'required',
        ]);

        //check if validation fails
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('gambar');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'gambar' => $image->hashName(),
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'ukuran' => $request->ukuran,
            'harga' => $request->harga,
        ]);

        return new ProductResource(true, 'Data Berhasil Ditambahkan !',$product);
    }

    public function show($id){
        $product = Product::find($id);

        return new ProductResource(true, 'Detail Data Product !', $product);
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'ukuran' => 'required',
            'harga' => 'required',
        ]);

        // Check Validasi
        if($validator->fails()){
            return response()->json($validator->error(),422);
        }

        $product = Product::find($id);

        // Check if image is not empty
        if($request->hasFile('gambar')){

            // Upload
            $image = $request->file('gambar');
            $image->storeAs('public/products', $image->hashName());

            //Delete old Image
            Storage::delete('public/products/' . basename($product->gambar));
            
            //Update post with new Image
            $product->update([
                'gambar' => $image->hashName(),
                'kategori_id' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'ukuran' => $request->ukuran,
                'harga' => $request->harga,
            ]);
       
        }else{
            $product->update([
                'kategori_id' => $request->kategori_id,
                'nama_produk' => $request->nama_produk,
                'deskripsi' => $request->deskripsi,
                'ukuran' => $request->ukuran,
                'harga' => $request->harga,
            ]);
        }

        return new ProductResource(true, 'Data Product Berhasil Diubah !', $product);
    }

    public function destroy($id){
        //find product by ID
        $product = Product::find($id);

        //delete Image
        Storage::delete('public/products/'.basename($product->gambar));

        //delete post
        $product->delete();

        return new ProductResource(true, 'Data Berhasil Dihapus !', null);

    }
}
