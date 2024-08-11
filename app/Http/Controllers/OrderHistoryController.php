<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderHistory;
use App\Models\ReceiveProduct;
use App\Models\Inventory;

class OrderHistoryController extends Controller
{

    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $orderhistorys = OrderHistory::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $orderhistorys = OrderHistory::orderBy('id', 'asc')->paginate(5);
        }

        return view('orderhistory.orderhistorys', ['orderhistorys' => $orderhistorys]);
    }

    public function store(Request $request)
    {
        // ตรวจสอบว่ามีสินค้าที่ถูกเลือกไว้หรือไม่
        if($request->has('selected_products')) {
            // ดึงข้อมูลสินค้าที่เลือกมาจากฟอร์ม
            $selectedProducts = $request->get('selected_products');
    
            // วนลูปเพื่อบันทึกข้อมูลสินค้าที่เลือกแต่ละตัว
            foreach($selectedProducts as $productId) {
                // สร้าง OrderHistory instance
                $orderHistory = new OrderHistory();
                
                // ดึงข้อมูลสินค้าจากฐานข้อมูล
                $receiveProduct = ReceiveProduct::find($productId);
    
                // กำหนดข้อมูลให้กับ OrderHistory instance
                $orderHistory->code = $receiveProduct->code;
                $orderHistory->product_name = $receiveProduct->product_name;
                $orderHistory->quantity_products_received = $receiveProduct->quantity_products_received;
                $orderHistory->unit = $receiveProduct->unit;
                $orderHistory->cost_unit = $receiveProduct->cost_unit;
                $orderHistory->total = $receiveProduct->total;
                
                // บันทึกข้อมูล OrderHistory
                $orderHistory->save();
    
                // ตรวจสอบว่าสินค้ามีอยู่ในคลังแล้วหรือไม่
                $inventoryItem = Inventory::where('code', $receiveProduct->code)->first();
                if($inventoryItem) {
                    // ถ้ามีอยู่แล้ว ให้บวกจำนวนที่รับเข้ามาใหม่กับจำนวนที่มีอยู่
                    $inventoryItem->amount += $receiveProduct->quantity_products_received;
                    $inventoryItem->save();
                } else {
                    // ถ้าไม่มี ให้สร้างรายการใหม่ใน Inventory
                    Inventory::create([
                        'code' => $receiveProduct->code,
                        'product_name' => $receiveProduct->product_name,
                        'unit' => $receiveProduct->unit,
                        'amount' => $receiveProduct->quantity_products_received,
                        // คุณอาจต้องการเพิ่มข้อมูลอื่น ๆ เช่น product_type, color, size, price ตามความเหมาะสม
                    ]);
                }
            }
    
            // ส่งกลับไปยังหน้าเดิมพร้อมกับข้อความ success
            return redirect()->route('orderhistory.orderhistorys')->with('success', 'บันทึกข้อมูลสินค้าเรียบร้อยแล้ว');
        } else {
            // หากไม่มีสินค้าที่ถูกเลือก
            return redirect()->back()->with('error', 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
        }
    }         
    
    public function edit(SupplierInformation $supplier) {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'vendor_id' => 'required',
            'company_name' => 'required',
            'customer_name' => 'required',
            'contact_number' => 'required|max:10',
            'email' => 'required'
        ]);
    
        $supplier = SupplierInformation::find($id);
        $supplier->vendor_id = $request->vendor_id;
        $supplier->company_name = $request->company_name;
        $supplier->customer_name = $request->customer_name;
        $supplier->contact_number = $request->contact_number;
        $supplier->email = $request->email;
        $supplier->save();
        return redirect()->route('supplier.suppliers')->with('success', 'แก้ไขข้อมูลผู้จัดจำหน่ายเรียบร้อยแล้ว');
    }    

    public function destroy(OrderHistory $orderhistory) {
        $orderhistory->delete();
        return response()->json(['success' => 'ประวัติการรับสินค้าเข้าคลังถูกลบเรียบร้อยแล้ว'], 200);
    }

}
