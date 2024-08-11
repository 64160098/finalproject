<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Product;
use App\Models\DailySale;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function showusername() {
        $username = auth()->user()->name;
        $currentDate = now()->locale('th')->isoFormat('LL');

        return view('admin', [
            'username' => $username,
            'currentDate' => $currentDate,
        ]);
    }

    public function index()
    {
        // นับจำนวนสินค้าทั้งหมด
        $productCount = Product::count();
    
        // ดึงข้อมูลยอดขายรายวัน
        $currentDate = Carbon::now()->startOfDay();
        $nextDate = $currentDate->copy()->addDay();
        $dailySales = DailySale::whereBetween('sale_date', [$currentDate, $nextDate])
                               ->orderBy('sale_date', 'desc')
                               ->get();
    
        // ดึงข้อมูลยอดขายรายเดือน
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $monthlySales = DailySale::whereBetween('sale_date', [$startOfMonth, $endOfMonth])
                                 ->orderBy('sale_date', 'asc')
                                 ->get();
    
        // คำนวณยอดขายรวมของเดือนนี้
        $totalMonthlySales = $monthlySales->sum('total_earning');
    
        // สร้างข้อมูลสำหรับกราฟ
        $salesData = [];
        foreach ($monthlySales as $sale) {
            $date = Carbon::parse($sale->sale_date)->locale('th')->isoFormat('D MMM');
            if (!isset($salesData[$date])) {
                $salesData[$date] = 0;
            }
            $salesData[$date] += $sale->total_earning;
        }
    
        // ส่งข้อมูลไปยัง view
        return view('admin', [
            'productCount' => $productCount,
            'dailySales' => $dailySales,
            'monthlySales' => $monthlySales,
            'totalMonthlySales' => $totalMonthlySales,
            'salesData' => $salesData,
        ]);
    }
    
    
}
