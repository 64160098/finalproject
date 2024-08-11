<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderList;
use App\Models\OrderProducts;

class OrderListController extends Controller
{
    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $orderlists = OrderList::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $orderlists = OrderList::orderBy('id', 'asc')->paginate(5);
        }

        return view('orderlist.orderlists', ['orderlists' => $orderlists]);
    }

    public function store(Request $request)
    {
        // ตรวจสอบว่ามีสินค้าที่ถูกเลือกไว้หรือไม่
        if($request->has('selected_products')) {
            // ดึงข้อมูลสินค้าที่เลือกมาจากฟอร์ม
            $selectedProducts = $request->get('selected_products');
    
            // วนลูปเพื่อบันทึกข้อมูลสินค้าที่เลือกแต่ละตัว
            foreach($selectedProducts as $productId) {
                // ดึงข้อมูลสินค้าจากฐานข้อมูล
                $orderProduct = OrderProducts::find($productId);

                if ($orderProduct) {
                    // ตรวจสอบว่ามีรายงานสินค้าตัวเดิมในวันเดียวกันหรือไม่
                    $existingReport = OrderList::where('code', $orderProduct->code)
                        ->whereDate('created_at', now()->toDateString())
                        ->first();
    
                    if ($existingReport) {
                        // ถ้ามีรายงานสินค้าตัวเดิมในวันเดียวกัน ให้บวกค่าเพิ่ม
                        $existingReport->quantity_products_order += $orderProduct->quantity_products_order;
                        $existingReport->total = (float)$existingReport->total + (float)$orderProduct->total;
                        $existingReport->save();
                    } else {
                        // ถ้าไม่มีรายงานสินค้าตัวเดิมในวันเดียวกัน ให้สร้างใหม่
                        OrderList::create([
                            'code' => $orderProduct->code,
                            'product_name' => $orderProduct->product_name,
                            'quantity_products_order' => $orderProduct->quantity_products_order,
                            'unit' => $orderProduct->unit,
                            'cost_unit' => $orderProduct->cost_unit,
                            'total' => $orderProduct->total,
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
        
    public function edit(OrderList $orderlist) {
        return view('orderlist.edit', compact('orderlist'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'quantity_products_order' => 'required',
        ]);
    
        $orderlist = OrderList::find($id);
        if ($orderlist) {
            // อัปเดตจำนวนสินค้าใน inventory report
            $orderlist->quantity_products_order = $request->quantity_products_order;
            
            // คำนวณค่า total โดยคูณจำนวนสินค้ากับราคาต่อหน่วย
            $orderlist->total = $orderlist->quantity_products_order * $orderlist->cost_unit;
            
            // บันทึกการเปลี่ยนแปลง
            $orderlist->save();
            return redirect()->route('orderlist.orderlists')->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('error', 'ไม่พบข้อมูลที่ต้องการแก้ไข');
        }
    }    

    public function destroy(OrderList $orderlist) {
        $orderlist->delete();
        return response()->json(['success' => 'รายการสั่งซื้อสินค้าถูกลบเรียบร้อยแล้ว'], 200);
    }
}
