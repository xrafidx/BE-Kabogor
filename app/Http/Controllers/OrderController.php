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
            $Orders = Order::All();
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
        // 1. Validasi otomatis oleh StoreOrderRequest
        $validatedData = $request->validated();
        $user = $request->user();
        
        // Array 'products' dari request, contoh:
        // [ {"product_id": 1, "quantity": 2}, {"product_id": 3, "quantity": 1} ]
        $productItems = $validatedData['products'];

        // Mulai Database Transaction
        // Ini memastikan jika ada 1 error, semua proses DB akan dibatalkan
        try {
            $order = DB::transaction(function () use ($user, $productItems) {
                
                // 7. Ambil semua ID produk dari request
                $productIds = collect($productItems)->pluck('product_id');
                
                // 8. Ambil data produk ASLI dari DB (hanya 1 query)
                //    Kita keyBy('id') agar mudah diakses
                $productsFromDB = Product::findMany($productIds)->keyBy('id');

                $totalPrice = 0;
                $pivotData = []; // Data untuk tabel order_product

                // 9. Hitung total harga & siapkan data pivot (di backend)
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

                // 10. Buat Order baru di tabel 'orders'
                $order = $user->orders()->create([
                    'total_price' => $totalPrice,
                    'status' => OrderStatus::PENDING, // Status default dari Enum
                ]);

                // 11. Lampirkan (attach) produk ke order di tabel pivot 'order_product'
                $order->products()->attach($pivotData);

                return $order;
            });

            // Jika transaction sukses, load relasinya dan kirim
            $order->load('products', 'user');

            return response()->json([
                "message" => "Order berhasil dibuat",
                "order" => $order
            ], 201); // 201 Created

        } catch (Throwable $e) {
            // Jika ada error di dalam transaction, batalkan
            return response()->json([
                "message" => "Pembuatan order gagal, silakan coba lagi.",
                "error" => $e->getMessage() // (Hapus ini di production)
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
        // 1. Validasi otomatis (cek 'status' ada & valid)
        $validated = $request->validated();
        $newStatus = OrderStatus::from($validated['status']); // Konversi string ke Objek Enum
        
        $user = $request->user();
        
        // 2. Cari order, tapi jangan 'findOrFail' dulu
        $order = Order::find($id);

        if (!$order) {
            return response()->json(["message" => "Order tidak ditemukan."], 404);
        }

        // 3. LOGIKA ADMIN: Boleh melakukan apa saja
        if ($user->is_admin) {
            $order->update(['status' => $newStatus]);
            
            return response()->json([
                "message" => "Status order berhasil diupdate oleh Admin",
                "order" => $order->fresh() // .fresh() utk ambil data terbaru
            ], 200);
        }

        // 4. LOGIKA USER BIASA:
        
        // Cek kepemilikan
        if ($order->user_id !== $user->id) {
            return response()->json(["message" => "Order ini bukan milik Anda."], 404); // Kirim 404 agar tidak bocor info
        }

        // User hanya boleh CANCEL
        if ($newStatus !== OrderStatus::CANCELLED) {
            return response()->json([
                "message" => "User hanya diizinkan mengubah status menjadi 'cancelled'."
            ], 403); // 403 Forbidden
        }

        // User hanya boleh CANCEL jika status masih PENDING
        if ($order->status !== OrderStatus::PENDING) {
            return response()->json([
                "message" => "Order tidak dapat dibatalkan karena sudah diproses."
            ], 403); // 403 Forbidden
        }

        // 5. Jika semua lolos (milik user, mau cancel, status pending)
        $order->update(['status' => OrderStatus::CANCELLED]);

        return response()->json([
            "message" => "Order berhasil dibatalkan",
            "order" => $order->fresh()
        ], 200);
    }

    public function editOrder(Request $request, string $id){
       // 1. Validasi otomatis (sama seperti createOrder)
        $validatedData = $request;
        $productItems = $validatedData['products']; // Keranjang baru

        // 2. Cari order yang mau di-edit
        $order = Order::findOrFail($id);

        return response()->json([
            "message" => "test",
            "test" => $productItems
        ], 200);

        // // Mulai Transaction (karena kita menyentuh 2 tabel)
        // try {
        //     $order = DB::transaction(function () use ($order, $productItems) {
                
        //         // 3. LOGIC LANGKAH 3-5 ANDA (Sama persis dgn createOrder)
        //         // Kita hitung ulang total harga berdasarkan keranjang baru
        //         $productIds = collect($productItems)->pluck('product_id');
        //         $productsFromDB = Product::findMany($productIds)->keyBy('id');

        //         $totalPrice = 0;
        //         $pivotData = []; // Data pivot baru

        //         foreach ($productItems as $item) {
        //             $product = $productsFromDB->get($item['product_id']);
        //             $quantity = $item['quantity'];
        //             $priceAtTime = $product->product_price; // Ambil harga asli

        //             $totalPrice += $priceAtTime * $quantity;

        //             // Siapkan data pivot baru
        //             $pivotData[$product->id] = [
        //                 'quantity' => $quantity,
        //                 'price_at_time' => $priceAtTime
        //             ];
        //         }

        //         // 4. LANGKAH 6 (UPDATE): Perbarui tabel 'orders'
        //         // Kita update total_price di order utamanya
        //         $order->update([
        //             'total_price' => $totalPrice
        //         ]);

        //         // 5. LANGKAH 6 (SYNC): Perbarui tabel 'order_product'
        //         // Ini adalah jawaban pertanyaan Anda.
        //         // sync() akan menambah, mengupdate, dan menghapus
        //         // data di tabel pivot secara otomatis.
        //         $order->products()->sync($pivotData);

        //         return $order;
        //     });

        //     // Jika transaction sukses
        //     $order->load('products', 'user'); // Ambil data relasi terbaru

        //     return response()->json([
        //         "message" => "Order berhasil di-update",
        //         "order" => $order
        //     ], 200); // 200 OK

        // } catch (Throwable $e) {
        //     // Jika ada error di dalam transaction
        //     return response()->json([
        //         "message" => "Update order gagal, silakan coba lagi.",
        //         "error" => $e->getMessage() // (Hapus ini di production)
        //     ], 500);
        // }
    }   
}