<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DailySale;
use App\Models\EmployeeInformation;
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
        $currentDate = now()->format('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ YYYY-MM-DD
        $employees = EmployeeInformation::all(); // ดึงข้อมูลพนักงานทั้งหมดจากตาราง
        return view('dailysale.create', [
            'currentDate' => $currentDate,
            'employees' => $employees,
        ]);
    }

    public function getEmployeeDetails($id)
    {
        // ดึงข้อมูลจากตาราง employee_information
        $employee = EmployeeInformation::find($id);
    
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        return response()->json([
            'employee' => [
                'id' => $employee->id,
                'firstname' => $employee->employee_firstname,
                'lastname' => $employee->employee_lastname,
                'contact_number' => $employee->employee_contact_number,
                'email' => $employee->employee_email,
                'status' => $employee->employee_status,
            ],
        ]);
    }

    //Store resource
    public function store(Request $request) {
        $request->validate([
            'total_earning' => 'required',
            'scan_to_pay' => 'required',
            'cash' => 'required',
            'sale_date' => 'required',
            'employee_id' => 'required|numeric',
        ]);

        $dailysale = new DailySale;
        $dailysale->total_earning = $request->total_earning;
        $dailysale->scan_to_pay = $request->scan_to_pay;
        $dailysale->cash = $request->cash;
        $dailysale->sale_date = $request->sale_date;
        $dailysale->employee_id = $request->input('employee_id');
        $dailysale->save();
        return redirect()->route('dailysale.dailysales')->with('success', 'รายงานยอดขายเรียบร้อยแล้ว');
    }

    public function edit($id) {

        $dailysale = DailySale::findOrFail($id);

        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();
        
        // ส่งข้อมูลไปยังวิว
        return view('dailysale.edit', [
            'dailysale' => $dailysale,
            'currentDate' => $dailysale->sale_date,
            'employees' => $employees,
            'selectedEmployeeId' => $dailysale->employee_id,
            'id' => $id // ส่ง $id ไปยังวิว
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'total_earning' => 'required',
            'scan_to_pay' => 'required',
            'cash' => 'required',
            'sale_date' => 'required',
            'employee_id' => 'required|numeric',
        ]);
        $dailysale = DailySale::findOrFail($id);
        $dailysale->total_earning = $request->total_earning;
        $dailysale->scan_to_pay = $request->scan_to_pay;
        $dailysale->cash = $request->cash;
        $dailysale->sale_date = $request->sale_date;
        $dailysale->employee_id = $request->input('employee_id');
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

    public function adminedit($id) {

        $admindailysale = DailySale::findOrFail($id);

        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();
        
        // ส่งข้อมูลไปยังวิว
        return view('dailysale.adminedit', [
            'admindailysale' => $admindailysale,
            'currentDate' => $admindailysale->sale_date,
            'employees' => $employees,
            'selectedEmployeeId' => $admindailysale->employee_id,
            'id' => $id // ส่ง $id ไปยังวิว
        ]);
    }

    public function adminupdate(Request $request, $id) {
        $request->validate([
            'total_earning' => 'required',
            'scan_to_pay' => 'required',
            'cash' => 'required',
            'sale_date' => 'required',
            'employee_id' => 'required|numeric',
        ]);
        $admindailysale = DailySale::findOrFail($id);
        $admindailysale->total_earning = $request->total_earning;
        $admindailysale->scan_to_pay = $request->scan_to_pay;
        $admindailysale->cash = $request->cash;
        $admindailysale->sale_date = $request->sale_date;
        $admindailysale->employee_id = $request->input('employee_id');
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
