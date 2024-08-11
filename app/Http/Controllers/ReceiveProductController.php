<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ReceiveProduct;
use App\Models\Inventory;

class ReceiveProductController extends Controller
{
     // Create Index
    public function index() {
        $receiveproducts = DB::table('receive_products')->orderBy('id', 'asc')->paginate(5);
        return view('receiveproduct.receiveproducts', ['receiveproducts' => $receiveproducts]);
    }


    // Create resource
    public function create() {
        return view('receiveproduct.create');
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
            $quantityReceived = $request->input('quantity_products_received_'.$selectedProductId);
            $unit = $request->input('unit');
            $price = $request->input('price');
            $total = $quantityReceived * $price;
            // dd($request->all());
    
            // เพิ่มข้อมูลสินค้าลงในฐานข้อมูล
            $receiveproduct = new ReceiveProduct;
            $receiveproduct->code = $code;
            $receiveproduct->product_name = $productName;
            $receiveproduct->quantity_products_received = $quantityReceived;
            $receiveproduct->unit = $unit;
            $receiveproduct->cost_unit = $price;
            $receiveproduct->total = $total;
            // โค้ดอื่น ๆ ที่เกี่ยวข้องกับ ReceiveProduct
            
            // บันทึกข้อมูลลงในฐานข้อมูล
            $receiveproduct->save();
            
            // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
            return redirect()->route('receiveproduct.receiveproducts')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
        }
        // ถ้าไม่มีสินค้าที่ถูกเลือก
        else {
            return redirect()->back()->with('error', 'กรุณาเลือกสินค้าก่อนที่จะดำเนินการต่อ');
        }
    }    
    

    public function edit(ReceiveProduct $receiveproduct) {
        return view('receiveproduct.edit', compact('receiveproduct'));
    }

    public function update(Request $request, $id) {
        // ดึงข้อมูลจำนวนสินค้าที่รับเข้ามาจากฟอร์ม
        $quantityReceived = $request->input('quantity_products_received');
    
        // คำนวณราคารวม
        $receiveproduct = ReceiveProduct::find($id);
        $price = $receiveproduct->cost_unit; // ใช้ราคาที่มีอยู่ในรายการเดิม
        $total = $quantityReceived * $price;
    
        // อัปเดตข้อมูลรายการสินค้า
        $receiveproduct->quantity_products_received = $quantityReceived;
        $receiveproduct->total = $total;
        $receiveproduct->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('receiveproduct.receiveproducts')->with('success', 'แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');
    }
    

    public function destroy(ReceiveProduct $receiveproduct) {
        $receiveproduct->delete();
        return response()->json(['success' => 'ลบข้อมูลสินค้าเรียบร้อยแล้ว'], 200);
    }

    public function showReceiveForm() {
        $products = Product::with('receiveproduct')->paginate(5);
        $receiveproducts = ReceiveProduct::with('product')->get();
        $inventories = Inventory::with('receiveproduct')->get();

        return view('receiveproduct.create', compact('products', 'receiveproducts', 'inventories'));
    }

    public function deleteAll()
    {
        // ดำเนินการลบข้อมูลทั้งหมดที่อยู่ในฐานข้อมูล
        ReceiveProduct::truncate();
        
        // ส่งคืนการตอบสนอง JSON
        return response()->json(['success' => 'รายการสินค้าทั้งหมดถูกยกเลิกแล้ว']);
    }  
    
}
