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
            $suppliers = SupplierInformation::where('id', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_name', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_customer_name', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_product', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_contact_number', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_email', 'like', "%{$searchTerm}%")
                ->paginate(5);
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
            'id' => 'required',
            'supplier_name' => 'required',
            'supplier_customer_name' => 'required',
            'supplier_product' => 'required',
            'supplier_contact_number' => 'required|max:10',
            'supplier_email' => 'required'
        ]);
              
        $supplier = new SupplierInformation;
        $supplier->id = $request->id;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_customer_name = $request->supplier_customer_name;
        $supplier->supplier_product = $request->supplier_product;
        $supplier->supplier_contact_number = $request->supplier_contact_number;
        $supplier->supplier_email = $request->supplier_email;
        $supplier->save();
        
        return redirect()->route('supplier.suppliers')->with('success', 'เพิ่มข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว');
    }

    public function edit(SupplierInformation $supplier) {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'id' => 'required',
            'supplier_name' => 'required',
            'supplier_customer_name' => 'required',
            'supplier_product' => 'required',
            'supplier_contact_number' => 'required|max:10',
            'supplier_email' => 'required'
        ]);
    
        $supplier = SupplierInformation::find($id);
        $supplier->id = $request->id;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_customer_name = $request->supplier_customer_name;
        $supplier->supplier_product = $request->supplier_product;
        $supplier->supplier_contact_number = $request->supplier_contact_number;
        $supplier->supplier_email = $request->supplier_email;
        $supplier->save();
        return redirect()->route('supplier.suppliers')->with('success', 'แก้ไขข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว');
    }    

    public function destroy(SupplierInformation $supplier) {
        $supplier->delete();
        return response()->json(['success' => 'ลบข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว'], 200);
    }
}
