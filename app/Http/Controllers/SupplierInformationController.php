<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierInformation;
use Illuminate\Support\Facades\DB;

class SupplierInformationController extends Controller
{
    // Create Index
    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $suppliers = SupplierInformation::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $suppliers = SupplierInformation::orderBy('id', 'asc')->paginate(5);
        }

        return view('supplier.suppliers', ['suppliers' => $suppliers]);
    }

    // Create resource
    public function create() {
        return view('supplier.create');
    }

    //Store resource
    public function store(Request $request) {
        $request->validate([
            'company_name' => 'required',
            'customer_name' => 'required',
            'about_product' => 'required',
            'contact_number' => 'required|max:10',
            'email' => 'required'
        ]);
              
        $supplier = new SupplierInformation;
        $supplier->company_name = $request->company_name;
        $supplier->customer_name = $request->customer_name;
        $supplier->about_product = $request->about_product;
        $supplier->contact_number = $request->contact_number;
        $supplier->email = $request->email;
        $supplier->save();
        
        return redirect()->route('supplier.suppliers')->with('success', 'เพิ่มข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว');
    }

    public function edit(SupplierInformation $supplier) {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'company_name' => 'required',
            'customer_name' => 'required',
            'about_product' => 'required',
            'contact_number' => 'required|max:10',
            'email' => 'required'
        ]);
    
        $supplier = SupplierInformation::find($id);
        $supplier->company_name = $request->company_name;
        $supplier->customer_name = $request->customer_name;
        $supplier->about_product = $request->about_product;
        $supplier->contact_number = $request->contact_number;
        $supplier->email = $request->email;
        $supplier->save();
        return redirect()->route('supplier.suppliers')->with('success', 'แก้ไขข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว');
    }    

    public function destroy(SupplierInformation $supplier) {
        $supplier->delete();
        return response()->json(['success' => 'ลบข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว'], 200);
    }
}
