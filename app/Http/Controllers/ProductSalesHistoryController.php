<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductSalesHistory;
use App\Models\ProductSaleReport;

class ProductSalesHistoryController extends Controller
{

    public function productsalehistorys() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $productsalehistorys = ProductSalesHistory::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $productsalehistorys = ProductSalesHistory::orderBy('id', 'asc')->paginate(5);
        }

        return view('productsalereport.productsalehistorys', ['productsalehistorys' => $productsalehistorys]);
    }

    public function store(Request $request)
    {
        // ตรวจสอบว่ามีสินค้าที่ถูกเลือกไว้หรือไม่
        if($request->has('selected_products')) {
            // ดึงข้อมูลสินค้าที่เลือกมาจากฟอร์ม
            $selectedProducts = $request->get('selected_products');
    
        // วนลูปเพื่อบันทึกข้อมูลสินค้าที่เลือกแต่ละตัว
        foreach ($selectedProducts as $productId) {
            // ดึงข้อมูลสินค้าจากฐานข้อมูล
            $productsalereport = ProductSaleReport::find($productId);
                
            if ($productsalereport) {
                // ตรวจสอบว่ามีรายงานสินค้าตัวเดิมในวันเดียวกันหรือไม่
                $existingReport = ProductSalesHistory::where('code', $productsalereport->code)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();
                
                if ($existingReport) {
                    // ถ้ามีรายงานสินค้าตัวเดิมในวันเดียวกัน ให้บวกค่าเพิ่ม
                    $existingReport->quantity_products_sale += $productsalereport->quantity_products_sale;
                    $existingReport->total = (float)$existingReport->total + (float)$productsalereport->total;
                    $existingReport->save();
                } else {
                    // ถ้าไม่มีรายงานสินค้าตัวเดิมในวันเดียวกัน ให้สร้างใหม่
                    ProductSalesHistory::create([
                        'code' => $productsalereport->code,
                        'product_name' => $productsalereport->product_name,
                        'quantity_products_sale' => $productsalereport->quantity_products_sale,
                        'unit' => $productsalereport->unit,
                        'cost_unit' => $productsalereport->cost_unit,
                        'total' => $productsalereport->total,
                        'created_at' => now()->toDateString(), // ใช้ toDateString เพื่อให้แน่ใจว่าเป็นรูปแบบ date
                    ]);
                }
            }
        }
    
            // ส่งกลับไปยังหน้าเดิมพร้อมกับข้อความ success ในรูปแบบ JSON
            return response()->json(['success' => true, 'message' => 'ส่งรายงานการขายสินค้าเรียบร้อยแล้ว']);
        } else {
            // หากไม่มีสินค้าที่ถูกเลือก
            return response()->json(['success' => false, 'message' => 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ']);
        }
    }    
     
    
    public function edit(ProductSalesHistory $productsalehistory) {
        return view('productsalereport.adminedit', compact('productsalehistory'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'quantity_products_sale' => 'required',
        ]);
    
        $productsalehistory = ProductSalesHistory::find($id);
        if ($productsalehistory) {
            // อัปเดตจำนวนสินค้าใน inventory report
            $productsalehistory->quantity_products_sale = $request->quantity_products_sale;
            
            // คำนวณค่า total โดยคูณจำนวนสินค้ากับราคาต่อหน่วย
            $productsalehistory->total = $productsalehistory->quantity_products_sale * $productsalehistory->cost_unit;
            
            // บันทึกการเปลี่ยนแปลง
            $productsalehistory->save();
            return redirect()->route('inventoryreport.admininventoryreports')->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลที่ต้องการแก้ไข');
        }
    }       

    public function destroy(ProductSalesHistory $productsalehistory) {
        $productsalehistory->delete();
        return response()->json(['success' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }

}
