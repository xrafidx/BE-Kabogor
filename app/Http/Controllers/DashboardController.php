<?php

namespace App\Http\Controllers;

use App\Models\Cta;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function getData(Request $request){
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $totalNewUser = User::whereBetween('created_at',array($startDate,$endDate))->count();
        $totalOrderSuccess = Order::whereBetween('created_at',array($startDate,$endDate))->where('status','completed')->count();
        $totalCta = Cta::whereBetween('created_at',array($startDate,$endDate))->count();
        $bestSellingProducts = DB::table('order_product')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->join('products', 'products.id', '=', 'order_product.product_id')
            ->where('orders.status', 'completed') // Hanya hitung order yang sukses
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.product_name', // Ambil Nama Produk
                DB::raw('CAST(SUM(order_product.quantity) AS INTEGER) as total_sold') // Ambil Total Terjual (di-cast ke int biar rapi)
            )
            ->groupBy('products.id', 'products.product_name') // Group by ID dan Nama
            ->orderByDesc('total_sold') // Urutkan dari yang terbanyak
            ->limit(2) // Ambil 2 Besar saja
            ->get();
        return response()->json([
            "message" => "Data Dashboard Berhasil Diambil",
            "data" => [
                'total_user' => $totalNewUser,
                'totalOrderSuccess' => $totalOrderSuccess,
                'cta' => $totalCta,
                'best_selling_products' => $bestSellingProducts
                
                ]
        ]);

    }

    public function incrementCta(){
        $cta = Cta::create();
                return response()->json([
            'message' => "Cta diklik"
        ],200);
    }

}
