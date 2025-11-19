<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    //
    public function getAll(Request $request){

        // query buat ambil semua produknya.
        $products = Product::all();

        // response
        return response()->json([
            "message" => "Produk Ditemukan",
            "Products" => $products
        ],200);

        
    }
    public function getSpecific(Request $request, String $id){
        // query buat nyari id
        $product = Product::findOrFail($id);

        // cek apakah produk ada.

        // kalo ada.
        return response()->json([
            "message" => "Product ditemukan",
            "product" => $product 
    ],200);


    }
    public function create(StoreProductRequest $request){
        $data = $request->validated();
        $imgUrl = null;

        if ($request->hasFile('product_img')) {
            $path = $request->file('product_img')->store('products', 'public'); 
            $imgUrl = $path;
        }
        $data['product_url_image'] = $imgUrl;

        $product = Product::create($data);

        return response()->json([
            "message" => "Product created successful",
            "data" => $product,
        ]);
    }

    // http://localhost:8000/storage/products/gC1XSNg0bVh46oiBZhURoU84T22GovXQo3npTmWa.png

    public function editSpecific(StoreProductRequest $request, String $id){
        // validasi data yang masuk.
        $validatedData = $request->validated();

        // cari produk yang mau diedit
        $product = Product::findOrFail($id);

        // Update Produk
        $product->update($validatedData);
        
        return response()->json([
            "message" => "Produk Berhasil Diupdate",
            "produk" => $product
        ],201);

    }
    public function deleteSpecific(Request $request, String $id){
        // query buat nyari id
        $product = Product::findOrFail($id);

        // cek apakah produk ada.

        // kalo ada.
        $product->delete();

        return response()->json([
            "message" => "Product dihapus",
            "product" => $product 
        ],200);
    }
}
