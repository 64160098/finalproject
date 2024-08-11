<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DailySale;
use Carbon\Carbon;

class DailySaleController extends Controller
{
    // Create Index
    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $dailysales = DailySale::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $dailysales = DailySale::orderBy('id', 'asc')->paginate(5);
        }

        return view('dailysale.dailysales', ['dailysales' => $dailysales]);
    }

    // Create resource
    public function create() {
        return view('dailysale.create');
    }

    //Store resource
    public function store(Request $request) {
        $request->validate([
            'total_earning' => 'required',
            'Scan_to_pay' => 'required',
            'cash' => 'required',
            'sale_date' => 'required',
            'reporter_name' => 'required',
        ]);

        $dailysale = new DailySale;
        $dailysale->total_earning = $request->total_earning;
        $dailysale->Scan_to_pay = $request->Scan_to_pay;
        $dailysale->cash = $request->cash;
        $dailysale->sale_date = $request->sale_date;
        $dailysale->reporter_name = $request->reporter_name;
        $dailysale->save();
        return redirect()->route('dailysale.dailysales')->with('success', 'รายงานยอดขายเรียบร้อยแล้ว');
    }

    public function edit(DailySale $dailysale) {
        return view('dailysale.edit', compact('dailysale'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'total_earning' => 'required',
            'Scan_to_pay' => 'required',
            'cash' => 'required',
            'sale_date' => 'required',
            'reporter_name' => 'required',
        ]);
        $dailysale = DailySale::find($id);
        $dailysale->total_earning = $request->total_earning;
        $dailysale->Scan_to_pay = $request->Scan_to_pay;
        $dailysale->cash = $request->cash;
        $dailysale->sale_date = $request->sale_date;
        $dailysale->reporter_name = $request->reporter_name;
        $dailysale->save();
        return redirect()->route('dailysale.dailysales')->with('success', 'แก้ไขรายงานยอดขายเรียบร้อยแล้ว');
    }

    public function destroy(DailySale $dailysale) {
        $dailysale->delete();
        return response()->json(['success' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }

    public function admindailysale() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $admindailysales = DailySale::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $admindailysales = DailySale::orderBy('id', 'asc')->paginate(5);
        }

        return view('dailysale.admindailysales', ['admindailysales' => $admindailysales]);
    }

    public function adminedit(DailySale $admindailysale) {
        return view('dailysale.adminedit', compact('admindailysale'));
    }

    public function adminupdate(Request $request, $id) {
        $request->validate([
            'total_earning' => 'required',
            'Scan_to_pay' => 'required',
            'cash' => 'required',
            'sale_date' => 'required',
        ]);
        $admindailysale = DailySale::find($id);
        $admindailysale->total_earning = $request->total_earning;
        $admindailysale->Scan_to_pay = $request->Scan_to_pay;
        $admindailysale->cash = $request->cash;
        $admindailysale->sale_date = $request->sale_date;
        $admindailysale->save();
        return redirect()->route('dailysale.admindailysales')->with('success', 'แก้ไขรายงานยอดขายเรียบร้อยแล้ว');
    }

    public function admindestroy(DailySale $admindailysale) {
        $admindailysale->delete();
        return response()->json(['success' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }

    public function adminmonthlysales() {
        return view('dailysale.adminmonthlysales');
    }

    // ฟังก์ชันใหม่สำหรับดึงและรวมยอดขายรายเดือนตามปีที่เลือก
    public function getMonthlySales(Request $request)
    {
        // รับค่าปีที่เลือกจาก request ถ้าไม่มีค่าปีที่เลือกจะใช้ปีปัจจุบัน
        $year = $request->input('year', Carbon::now()->year);
    
        // ดึงข้อมูลยอดขายของปีที่เลือกจากฐานข้อมูล
        $dailysales = DailySale::whereYear('sale_date', $year)->get();
    
        // สร้างอาเรย์เพื่อเก็บยอดขายรายเดือน
        $monthlySales = [];
    
        // ตัวแปรสำหรับเก็บยอดขายรวมทั้งหมด
        $totalSales = 0;
    
        // วนลูปผ่านยอดขายรายวันทั้งหมด
        foreach ($dailysales as $sale) {
            // แปลงวันที่เป็นชื่อเดือนและปี เช่น June 2024
            $month = Carbon::parse($sale->sale_date)->locale('th')->isoFormat('MMMM');
    
            // ถ้ายังไม่มีเดือนนี้ในอาเรย์ ให้กำหนดค่าเริ่มต้นเป็น 0
            if (!isset($monthlySales[$month])) {
                $monthlySales[$month] = 0;
            }
    
            // เพิ่มยอดขายของวันนั้นเข้าไปในยอดขายรวมของเดือนนั้น
            $monthlySales[$month] += $sale->total_earning;
    
            // เพิ่มยอดขายของวันนั้นเข้าไปในยอดขายรวมทั้งหมด
            $totalSales += $sale->total_earning;
        }
    
        // คืนค่าข้อมูลยอดขายรายเดือนและยอดขายรวมทั้งหมด
        return view('dailysale.adminmonthlysales', [
            'monthlySales' => $monthlySales,
            'totalSales' => $totalSales,
            'selectedYear' => $year
        ]);
    }
}
