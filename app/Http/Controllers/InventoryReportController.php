<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\InventoryReport;

class InventoryReportController extends Controller
{
     // Create Index
     public function index() {
        $inventoryreports = DB::table('inventory_reports')->orderBy('id', 'asc')->paginate(5);
        return view('inventoryreport.inventoryreports', ['inventoryreports' => $inventoryreports]);
    }


    // Create resource
    public function create() {
        return view('inventoryreport.create');
    }

    //Store resource
    public function store(Request $request) {

        // ตรวจสอบว่ามีสินค้าที่ถูกเลือกหรือไม่
        if ($request->has('selected_product')) {
            // ดึงข้อมูลของสินค้าที่ถูกเลือก
            $selectedProductId = $request->input('selected_product');
    
            // ดึงข้อมูลของสินค้าที่ถูกเลือกจากฟอร์ม
            $code = $request->input('code');
            $productName = $request->input('product_name');
            $quantitySold = $request->input('quuantity_products_sold'.$selectedProductId);
            $unit = $request->input('unit');
            $price = $request->input('price');
            $total = $quantitySold * $price;
            // dd($request->all());
    
            // เพิ่มข้อมูลสินค้าลงในฐานข้อมูล
            $inventoryreport = new InventoryReport;
            $inventoryreport->code = $code;
            $inventoryreport->product_name = $productName;
            $inventoryreport->quuantity_products_sold = $quantitySold;
            $inventoryreport->unit = $unit;
            $inventoryreport->cost_unit = $price;
            $inventoryreport->total = $total;
            // โค้ดอื่น ๆ ที่เกี่ยวข้องกับ ReceiveProduct
            
            // บันทึกข้อมูลลงในฐานข้อมูล
            $inventoryreport->save();
            
            // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
            return redirect()->route('inventoryreport.inventoryreports')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
        }
        // ถ้าไม่มีสินค้าที่ถูกเลือก
        else {
            return redirect()->back()->with('error', 'กรุณาเลือกสินค้าก่อนที่จะดำเนินการต่อ');
        }
    }    
    

    public function edit(InventoryReport $inventoryreport) {
        return view('inventoryreport.edit', compact('inventoryreport'));
    }

    public function update(Request $request, $id) {
        // ดึงข้อมูลจำนวนสินค้าที่รับเข้ามาจากฟอร์ม
        $quantitySold = $request->input('quuantity_products_sold');
    
        // คำนวณราคารวม
        $inventoryreport = InventoryReport::find($id);
        $price = $inventoryreport->cost_unit; // ใช้ราคาที่มีอยู่ในรายการเดิม
        $total = $quantitySold * $price;
    
        // อัปเดตข้อมูลรายการสินค้า
        $inventoryreport->quuantity_products_sold = $quantitySold;
        $inventoryreport->total = $total;
        $inventoryreport->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('inventoryreport.inventoryreports')->with('success', 'แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');
    }
    

    public function destroy(InventoryReport $inventoryreport) {
        $inventoryreport->delete();
        return response()->json(['success' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }

    public function showReportForm() {
        $products = Product::with('inventoryreport')->paginate(5);
        $inventoryreports = InventoryReport::with('product')->get();

        return view('inventoryreport.create', compact('products', 'inventoryreports'));
    }

    public function deleteAll(Request $request)
    {
        // ลบข้อมูลทั้งหมดใน InventoryReport
        InventoryReport::truncate();

        return response()->json(['message' => 'ยกเลิกรายการทั้งหมดสำเร็จ'], 200);
    }

}
