<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class OrderController extends Controller
{
    //
    public function showAllOrder(Request $request){
        // Cek dia admin apa bukan
         if ($request->user() && $request->user()->is_admin){
            // Jika admin show semua order yang ada di DB
            $Orders = Order::with('user')->get();
            // response
            return response()->json([
                "message" => "Data Order Untuk Admin Ditemukan",
                "Orders" => $Orders
            ],200);

         }
         // Kalo Bukan admin (User) show semua order yang dimiliki oleh user tersebut.
         else{
            $user = $request->user();
            $user->load('orders.products');
            return response()->json([
                "message" => "Order Ditemukan",
                "Orders" => $user->orders
            ],200);

         }
    }
    public function showSpecificOrder(Request $request, string $id){
        // Cek dia admin apa bukan
         if ($request->user() && $request->user()->is_admin){
            // Jika admin show semua order yang ada di DB
            $Order = Order::with('products')->findOrFail($id);
            // response
            return response()->json([
                "message" => "Data Order Untuk Admin Ditemukan",
                "Order" => $Order
            ],200);
         }
         else{
            $user = $request->user();
            $order = $user->orders()->with('products')->findOrFail($id);
            return response()->json([
                    "message" => "Order Anda ditemukan",
                    "order" => $order
            ], 200);

         }


    }
    public function createOrder(StoreOrderRequest $request){
        $validatedData = $request->validated();
        $user = $request->user();
        

        $productItems = $validatedData['products'];


        try {
            $order = DB::transaction(function () use ($user, $productItems) {
                
                // Ambil semua ID produk dari request
                $productIds = collect($productItems)->pluck('product_id');
                
                // Ambil data produk ASLI dari DB 
                //keyBy('id') 
                $productsFromDB = Product::findMany($productIds)->keyBy('id');

                $totalPrice = 0;
                $pivotData = []; // Data untuk tabel order_product

                // Hitung total harga & siapkan data pivot (di backend)
                foreach ($productItems as $item) {
                    $product = $productsFromDB->get($item['product_id']);
                    $quantity = $item['quantity'];
                    $priceAtTime = $product->product_price; // Harga asli dari DB

                    $totalPrice += $priceAtTime * $quantity;

                    // Siapkan data untuk tabel pivot
                    $pivotData[$product->id] = [
                        'quantity' => $quantity,
                        'price_at_time' => $priceAtTime
                    ];
                }

                // Buat Order baru di tabel 'orders'
                $order = $user->orders()->create([
                    'total_price' => $totalPrice,
                    'status' => OrderStatus::PENDING, 
                ]);

                //  produk ke order di tabel pivot 'order_product'
                $order->products()->attach($pivotData);

                return $order;
            });

            // Jika transaction sukses, load relasinya dan kirim
            $order->load('products', 'user');

            return response()->json([
                "message" => "Order berhasil dibuat",
                "order" => $order
            ], 201); 

        } catch (Throwable $e) {
            return response()->json([
                "message" => "Pembuatan order gagal, silakan coba lagi.",
                "error" => $e->getMessage() 
            ], 500);
        }

    }
    public function deleteOrder(Request $request, string $id){
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json([
            "message" => "Order dihapus",
            "order" => $order
        ],200);


    }
    public function editState(UpdateOrderStatusRequest $request, string $id){
        $validated = $request->validated();
        $newStatus = OrderStatus::from($validated['status']); // Konversi string ke Objek Enum
        
        $user = $request->user();
        
        $order = Order::find($id);

        if (!$order) {
            return response()->json(["message" => "Order tidak ditemukan."], 404);
        }

        // ADMIN: sabeb mau ngapain aje
        if ($user->is_admin) {
            $order->update(['status' => $newStatus]);
            
            return response()->json([
                "message" => "Status order berhasil diupdate oleh Admin",
                "order" => $order->fresh() // .fresh() utk ambil data terbaru
            ], 200);
        }

        // USER BIASA:
        
        // Cek kepemilikan
        if ($order->user_id !== $user->id) {
            return response()->json(["message" => "Order ini bukan milik Anda."], 404); 
        }

        // User hanya boleh CANCEL
        if ($newStatus !== OrderStatus::CANCELLED) {
            return response()->json([
                "message" => "User hanya diizinkan mengubah status menjadi 'cancelled'."
            ], 403); 
        }

        // User hanya boleh CANCEL jika status masih PENDING
        if ($order->status !== OrderStatus::PENDING) {
            return response()->json([
                "message" => "Order tidak dapat dibatalkan karena sudah diproses."
            ], 403); 
        }

        // (milik user, mau cancel, status pending)
        $order->update(['status' => OrderStatus::CANCELLED]);

        return response()->json([
            "message" => "Order berhasil dibatalkan",
            "order" => $order->fresh()
        ], 200);
    }

    public function editOrder(StoreOrderRequest $request, string $id){
        $validatedData = $request->validated();
        $productItems = $validatedData['products']; // Keranjang baru

        // Cari order yang mau di-edit
        $order = Order::findOrFail($id);

        try {
            $order = DB::transaction(function () use ($order, $productItems) {
                
                // hitung ulang total harga berdasarkan keranjang baru
                $productIds = collect($productItems)->pluck('product_id');
                $productsFromDB = Product::findMany($productIds)->keyBy('id');

                $totalPrice = 0;
                $pivotData = []; // Data pivot baru

                foreach ($productItems as $item) {
                    $product = $productsFromDB->get($item['product_id']);
                    $quantity = $item['quantity'];
                    $priceAtTime = $product->product_price; // Ambil harga asli

                    $totalPrice += $priceAtTime * $quantity;

                    // data pivot baru
                    $pivotData[$product->id] = [
                        'quantity' => $quantity,
                        'price_at_time' => $priceAtTime
                    ];
                }

                // Perbarui tabel 'orders'
                // update total_price di order utamanya
                $order->update([
                    'total_price' => $totalPrice
                ]);

                // Perbarui tabel 'order_product'
                // sync() menambah, mengupdate, dan menghapus
                // data di tabel pivot 
                $order->products()->sync($pivotData);

                return $order;
            });

            // Jika transaction sukses
            $order->load('products', 'user'); // Ambil data relasi terbaru

            return response()->json([
                "message" => "Order berhasil di-update",
                "order" => $order
            ], 200); // 200 OK

        } catch (Throwable $e) {
            // Jika ada error di dalam transaction
            return response()->json([
                "message" => "Update order gagal, silakan coba lagi.",
                "error" => $e->getMessage() 
            ], 500);
        }
    }   
}