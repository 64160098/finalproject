<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\OrderProducts;

class OrderProductController extends Controller
{
     // Create Index
     public function index() {
        $orderproducts = DB::table('order_products')->orderBy('id', 'asc')->paginate(5);
        return view('orderproduct.orderproducts', ['orderproducts' => $orderproducts]);
    }


    // Create resource
    public function create() {
        return view('orderproduct.create');
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
            $quantityOrder = $request->input('quantity_products_order'.$selectedProductId);
            $unit = $request->input('unit');
            $price = $request->input('price');
            $total = $quantityOrder * $price;
            // dd($request->all());
    
            // เพิ่มข้อมูลสินค้าลงในฐานข้อมูล
            $orderproduct = new OrderProducts;
            $orderproduct->code = $code;
            $orderproduct->product_name = $productName;
            $orderproduct->quantity_products_order = $quantityOrder;
            $orderproduct->unit = $unit;
            $orderproduct->cost_unit = $price;
            $orderproduct->total = $total;
            // โค้ดอื่น ๆ ที่เกี่ยวข้องกับ ReceiveProduct
            
            // บันทึกข้อมูลลงในฐานข้อมูล
            $orderproduct->save();
            
            // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
            return redirect()->route('orderproduct.orderproducts')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
        }
        // ถ้าไม่มีสินค้าที่ถูกเลือก
        else {
            return redirect()->back()->with('error', 'กรุณาเลือกสินค้าก่อนที่จะดำเนินการต่อ');
        }
    }    
    

    public function edit(OrderProducts $orderproduct) {
        return view('orderproduct.edit', compact('orderproduct'));
    }

    public function update(Request $request, $id) {
        // ดึงข้อมูลจำนวนสินค้าที่รับเข้ามาจากฟอร์ม
        $quantityOrder = $request->input('quantity_products_order');
    
        // คำนวณราคารวม
        $orderproduct = OrderProducts::find($id);
        $price = $orderproduct->cost_unit; // ใช้ราคาที่มีอยู่ในรายการเดิม
        $total = $quantityOrder * $price;
    
        // อัปเดตข้อมูลรายการสินค้า
        $orderproduct->quantity_products_order = $quantityOrder;
        $orderproduct->total = $total;
        $orderproduct->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('orderproduct.orderproducts')->with('success', 'แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');
    }
    

    public function destroy(OrderProducts $orderproduct) {
        $orderproduct->delete();
        return response()->json(['success' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }

    public function showOrderForm() {
        $products = Product::with('orderproduct')->paginate(5);
        $orderproducts = OrderProducts::with('product')->get();

        return view('orderproduct.create', compact('products', 'orderproducts'));
    }

    public function deleteAll()
    {
        // ดำเนินการลบข้อมูลทั้งหมดที่อยู่ในฐานข้อมูล
        OrderProducts::truncate();
        
        // ส่งคืนการตอบสนอง JSON
        return response()->json(['success' => 'รายการสินค้าทั้งหมดถูกยกเลิกแล้ว']);
    }  
    
}
