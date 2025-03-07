<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeInformation;
use Illuminate\Support\Facades\DB;

class EmployeeInformationController extends Controller
{
    // Create Index
    public function index() {
            // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $employees = EmployeeInformation::where('id', 'like', "%{$searchTerm}%")
                ->orWhere('employee_firstname', 'like', "%{$searchTerm}%")
                ->orWhere('employee_lastname', 'like', "%{$searchTerm}%")
                ->orWhere('employee_contact_number', 'like', "%{$searchTerm}%")
                ->orWhere('employee_email', 'like', "%{$searchTerm}%")
                ->orWhere('employee_status', 'like', "%{$searchTerm}%")
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $employees = EmployeeInformation::orderBy('id', 'asc')->paginate(5);
        }

        return view('employee.employees', ['employees' => $employees]);
    }

    // Create resource
    public function create() {
        return view('employee.create');
    }

    //Store resource
    public function store(Request $request) {

        $existingEmployee = EmployeeInformation::where('id', $request->id)
        ->first();
        
        if ($existingEmployee) {
            if ($existingEmployee->id === $request->id) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['id' => ['รหัสพนักงานนี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['id' => 'รหัสพนักงานนี้ถูกใช้ไปแล้ว']);
            }
        } 
    
        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $validatedData = $request->validate([
            'id' => 'required',
            'employee_firstname' => 'required',
            'employee_lastname' => 'required',
            'employee_contact_number' => 'required|max:10',
            'employee_email' => 'required',
            'employee_status' => 'required',
        ]);
    
        
        // บันทึกข้อมูลพนักงานใหม่
        $employee = new EmployeeInformation;
        $employee->id = $request->id;
        $employee->employee_firstname = $request->employee_firstname;
        $employee->employee_lastname = $request->employee_lastname;
        $employee->employee_contact_number = $request->employee_contact_number;
        $employee->employee_email = $request->employee_email;
        $employee->employee_status = $request->employee_status;
        $employee->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว'], 200);
        }
        
        return redirect()->route('employee.employees')->with('success', 'เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว');
    }    

    public function edit(EmployeeInformation $employee) {
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'id' => 'required',
            'employee_firstname' => 'required',
            'employee_lastname' => 'required',
            'employee_contact_number' => 'required|max:10',
            'employee_email' => 'required',
            'employee_status' => 'required',
        ]);

                // ตรวจสอบว่ามีข้อมูลที่มีรหัสหรือชื่อซ้ำกับข้อมูลที่ไม่ใช่ตัวเองหรือไม่
                $existingEmployeeInformation = EmployeeInformation::where('id', '!=', $id) // ไม่รวมตัวเองที่กำลังอัปเดต
                ->where(function($query) use ($request) {
                    $query->where('id', $request->id);
                })
                ->first();
        
            if ($existingEmployeeInformation) {
                // ตรวจสอบว่ารหัสประเภทสินค้าซ้ำหรือไม่
                if ($existingEmployeeInformation->employee_id === $request->employee_id) {
                    if ($request->ajax()) {
                        return response()->json(['errors' => ['id' => ['รหัสพนักงานนี้ถูกใช้ไปแล้ว']]], 422);
                    }
                    return back()->withErrors(['id' => 'รหัสพนักงานนี้ถูกใช้ไปแล้ว']);
                } 
            } 
    
        $employee = EmployeeInformation::find($id);
        $employee->id = $request->id;
        $employee->employee_firstname = $request->employee_firstname;
        $employee->employee_lastname = $request->employee_lastname;
        $employee->employee_contact_number = $request->employee_contact_number;
        $employee->employee_email = $request->employee_email;
        $employee->employee_status = $request->employee_status;
        $employee->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'แก้ไขข้อมูลพนักงานเรียบร้อยแล้ว']);
        }

        return redirect()->route('employee.employees')->with('success', 'แก้ไขข้อมูลพนักงานเรียบร้อยแล้ว');
    }    

    public function destroy(EmployeeInformation $employee) {
        $employee->delete();
        return response()->json(['success' => 'ลบข้อมูลพนักงานเรียบร้อยแล้ว'], 200);
    }
}
