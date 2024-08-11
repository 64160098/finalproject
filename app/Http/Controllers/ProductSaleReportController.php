<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductSaleReport;
use App\Models\Product;

class ProductSaleReportController extends Controller
{
    public function index() {
        $productsalereports = DB::table('product_sale_reports')->orderBy('id', 'asc')->paginate(5);
        return view('productsalereport.productsalereports', ['productsalereports' => $productsalereports]);
    }

    // Create resource
    public function create() {
        return view('productsalereport.create');
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
                $quantitySale = $request->input('quantity_products_sale'.$selectedProductId);
                $unit = $request->input('unit');
                $price = $request->input('price');
                $total = $quantitySale * $price;
                // dd($request->all());
        
                // เพิ่มข้อมูลสินค้าลงในฐานข้อมูล
                $productsalereport = new ProductSaleReport;
                $productsalereport->code = $code;
                $productsalereport->product_name = $productName;
                $productsalereport->quantity_products_sale = $quantitySale;
                $productsalereport->unit = $unit;
                $productsalereport->cost_unit = $price;
                $productsalereport->total = $total;
                // โค้ดอื่น ๆ ที่เกี่ยวข้องกับ ReceiveProduct
                
                // บันทึกข้อมูลลงในฐานข้อมูล
                $productsalereport->save();
                
                // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
                return redirect()->route('productsalereport.productsalereports')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
            }
            // ถ้าไม่มีสินค้าที่ถูกเลือก
            else {
                return redirect()->back()->with('error', 'กรุณาเลือกสินค้าก่อนที่จะดำเนินการต่อ');
            }
        }
        
            public function edit(ProductSaleReport $productsalereport) {
        return view('productsalereport.edit', compact('productsalereport'));
    }

    public function update(Request $request, $id) {
        // ดึงข้อมูลจำนวนสินค้าที่รับเข้ามาจากฟอร์ม
        $quantitySale = $request->input('quantity_products_sale');
    
        // คำนวณราคารวม
        $productsalereport = ProductSaleReport::find($id);
        $price = $productsalereport->cost_unit; // ใช้ราคาที่มีอยู่ในรายการเดิม
        $total = $quantitySale * $price;
    
        // อัปเดตข้อมูลรายการสินค้า
        $productsalereport->quantity_products_sale = $quantitySale;
        $productsalereport->total = $total;
        $productsalereport->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('productsalereport.productsalereports')->with('success', 'แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(ProductSaleReport $productsalereport) {
        $productsalereport->delete();
        return response()->json(['success' => 'ลบข้อมูลสินค้าเรียบร้อยแล้ว'], 200);
    }

    public function showProductForm() {
        $products = Product::with('productsalereport')->paginate(5);
        $productsalereports = ProductSaleReport::with('product')->get();

        return view('productsalereport.create', compact('products', 'productsalereports'));
    }

    public function deleteAll()
    {
        // ดำเนินการลบข้อมูลทั้งหมดที่อยู่ในฐานข้อมูล
        ProductSaleReport::truncate();
        
        // ส่งคืนการตอบสนอง JSON
        return response()->json(['success' => 'รายการสินค้าทั้งหมดถูกยกเลิกแล้ว']);
    }  
}
