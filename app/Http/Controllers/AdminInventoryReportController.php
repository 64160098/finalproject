<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AdminInventoryReport;
use App\Models\InventoryReport;

class AdminInventoryReportController extends Controller
{

    public function admininventoryreports() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $admininventoryreports = AdminInventoryReport::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $admininventoryreports = AdminInventoryReport::orderBy('id', 'asc')->paginate(5);
        }

        return view('inventoryreport.admininventoryreports', ['admininventoryreports' => $admininventoryreports]);
    }

    public function store(Request $request)
    {
        // ตรวจสอบว่ามีสินค้าที่ถูกเลือกไว้หรือไม่
        if ($request->has('selected_products')) {
            // ดึงข้อมูลสินค้าที่เลือกมาจากฟอร์ม
            $selectedProducts = $request->get('selected_products');
    
            // วนลูปเพื่อบันทึกข้อมูลสินค้าที่เลือกแต่ละตัว
            foreach ($selectedProducts as $productId) {
                // ดึงข้อมูลสินค้าจากฐานข้อมูล
                $inventoryreport = InventoryReport::find($productId);
    
                if ($inventoryreport) {
                    // ตรวจสอบว่ามีรายงานสินค้าตัวเดิมในวันเดียวกันหรือไม่
                    $existingReport = AdminInventoryReport::where('code', $inventoryreport->code)
                        ->whereDate('created_at', now()->toDateString())
                        ->first();
    
                    if ($existingReport) {
                        // ถ้ามีรายงานสินค้าตัวเดิมในวันเดียวกัน ให้บวกค่าเพิ่ม
                        $existingReport->quantity_inventories += $inventoryreport->quuantity_products_sold;
                        $existingReport->total = (float)$existingReport->total + (float)$inventoryreport->total;
                        $existingReport->save();
                    } else {
                        // ถ้าไม่มีรายงานสินค้าตัวเดิมในวันเดียวกัน ให้สร้างใหม่
                        AdminInventoryReport::create([
                            'code' => $inventoryreport->code,
                            'product_name' => $inventoryreport->product_name,
                            'quantity_inventories' => $inventoryreport->quuantity_products_sold,
                            'unit' => $inventoryreport->unit,
                            'cost_unit' => $inventoryreport->cost_unit,
                            'total' => $inventoryreport->total,
                            'created_at' => now()->toDateString(), // ใช้ toDateString เพื่อให้แน่ใจว่าเป็นรูปแบบ date
                        ]);
                    }
                }
            }
    
            // ส่งกลับไปยังหน้าเดิมพร้อมกับข้อความ success ในรูปแบบ JSON
            return response()->json(['success' => true, 'message' => 'ส่งรายงานสินค้าคงเหลือเรียบร้อยแล้ว']);
        } else {
            // หากไม่มีสินค้าที่ถูกเลือก
            return response()->json(['success' => false, 'message' => 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ']);
        }
    }
    
    
    public function edit(AdminInventoryReport $admininventoryreport) {
        return view('inventoryreport.adminedit', compact('admininventoryreport'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'quantity_inventories' => 'required',
        ]);
    
        $admininventoryreport = AdminInventoryReport::find($id);
        if ($admininventoryreport) {
            // อัปเดตจำนวนสินค้าใน inventory report
            $admininventoryreport->quantity_inventories = $request->quantity_inventories;
            
            // คำนวณค่า total โดยคูณจำนวนสินค้ากับราคาต่อหน่วย
            $admininventoryreport->total = $admininventoryreport->quantity_inventories * $admininventoryreport->cost_unit;
            
            // บันทึกการเปลี่ยนแปลง
            $admininventoryreport->save();
            return redirect()->route('inventoryreport.admininventoryreports')->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลที่ต้องการแก้ไข');
        }
    }    

    public function destroy(AdminInventoryReport $admininventoryreport) {
        $admininventoryreport->delete();
        return response()->json(['success' => 'รายงานสินค้าคงเหลือถูกลบเรียบร้อยแล้ว'], 200);
    }

}
