<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function dashboardData(Request $request){

        $startDate = $request->input('start_date') 
                     ? Carbon::parse($request->input('start_date'))->startOfDay() 
                     : null; 
                     
        // Jika filter diisi, kita parse dan ambil waktu end hari tsb (23:59:59). Jika kosong, biarkan null.
        $endDate = $request->input('end_date') 
                   ? Carbon::parse($request->input('end_date'))->endOfDay() 
                   : null;

        // user yang dicreate di rentang tanggal
        $usersCreatedInPeriod = User::query()
    ->whereBetween('created_at', [$startDate, $endDate])
    ->count();
        // order yang completed di rentang tanggal segitu
        $completedOrdersInPeriod = Order::query()
    ->where('status', OrderStatus::COMPLETED)
    ->whereBetween('created_at', [$startDate, $endDate])
    ->count();

        

        // Buat hitung jumlah user (non admin)
        $jumlahNonAdmin = User::where('is_admin', false)->count();
        // Jumlah orderan yang udah berhasil
        $jumlahOrderSukses = Order::where('status', OrderStatus::COMPLETED)->count();
        // Total Produk yang dibuat sepanjang masa
        $totalProducts = Product::count();
        // Pengguna Baru Hari Ini
        $countToday = User::whereDate('created_at', Carbon::today())->count();
        // Pesanan Baru Hari Ini
$ordersTodayUncancelled = Order::query()
    ->whereDate('created_at', Carbon::today())
    ->whereNot('status', OrderStatus::CANCELLED)
    ->count(); // <-- INI YANG HARUS DIPAKAI
        // Klik CTA Hari Ini




        return view('dashboard', compact('jumlahNonAdmin', 'jumlahOrderSukses', 'totalProducts','countToday','ordersTodayUncancelled','usersCreatedInPeriod','completedOrdersInPeriod'));
    }
}
