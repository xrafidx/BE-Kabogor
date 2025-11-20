<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;



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
        // ngambil validated data dulu
        // create imgUrl tapi dibikin kosong dulu.
        // kalo di requestnya ada product_img, baru bikinin file pathnya. dan store gambarnya.
        // tambahin di array product pas di create.
        $data = $request->validated();
        $imgUrl = null;

        if ($request->hasFile('product_img')) {
            $path = $request->file('product_img')->store('products', 'public'); 
            $imgUrl = $path;
            $data['product_url_image'] = $imgUrl;
        }

        $product = Product::create($data);

        return response()->json([
            "message" => "Product created successful",
            "data" => $product,
        ]);
    }

    // http://localhost:8000/storage/products/gC1XSNg0bVh46oiBZhURoU84T22GovXQo3npTmWa.png

    public function editSpecific(StoreProductRequest $request, string $id){
        // validasi data yang masuk.
        $validatedData = $request->validateResolved();
        // // initialize buat path image
        // $imgUrl = null;

        // // cari produk yang mau diedit
        // $product = Product::findOrFail($id);

        // // cek kalo ada image yang dikirim apa engga, kalo ada langsung di store.
        // if ($request->hasFile('product_img')) {
        //     $path = $request->file('product_img')->store('products', 'public'); 
        //     $imgUrl = $path;
        //     // langsung store url_image baru, kalo seandainya ada image baru.
        //     $validatedData['product_url_image'] = $imgUrl;

        //     // cek kalo product apakah udah punya gambar sebelumnya jika udah hapus gambar lama
        //     if($product['product_url_image'] != null){
        //         $oldImageUrl = $product['product_url_image'];
        //         Storage::disk('public')->delete($oldImageUrl);
        //     }

        // }
        // else{
        //     // karena ga ada image baru, berarti tetep pake url lama dari product yang udah ada.
        //     $validatedData['product_url_image'] = $product['product_url_image'];
        // }

        // // Update Produk
        // $product->update($validatedData);
        
        return response()->json([
            "message" => "Produk Berhasil Diupdate",
            "produk" => $validatedData
        ],201);

    }
    public function deleteSpecific(Request $request, String $id){
        // query buat nyari id
        $product = Product::findOrFail($id);

        // ini kalo seandainya product yang mau dihapus ketemu dan productnya punya gambar
        if($product['product_url_image'] != null && $product){
            $oldImageUrl = $product['product_url_image'];
            Storage::disk('public')->delete($oldImageUrl);
        }

        // kalo ada.
        $product->delete();

        return response()->json([
            "message" => "Product dihapus",
            "product" => $product 
        ],200);
    }
}
