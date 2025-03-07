<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ReceiveProduct;
use App\Models\Inventory;
use App\Models\Ordernow;
use App\Models\SupplierInformation;
use App\Models\EmployeeInformation;

class ReceiveProductController extends Controller
{

    public function index(Request $request) {
        // ดึงรายการสินค้าทั้งหมด
        $receiveproducts = DB::table('receive_products')->orderBy('order_id', 'asc')->paginate(5);
    
        // ตรวจสอบว่ามีการระบุ orderId ใน Query String หรือไม่
        $orderId = $request->query('orderId');
        $ordernow = null;
        $productDetails = collect(); // สร้างคอลเล็กชันว่าง
        $employee = null;
        $supplier = null;
    
        if ($orderId) {
            // ดึงข้อมูล order โดยใช้ ID
            $ordernow = Ordernow::find($orderId);
    
            if ($ordernow) {
                // ดึงข้อมูลผลิตภัณฑ์และรายละเอียดที่เกี่ยวข้องจาก JSON ในใบสั่งซื้อ
                $orderedProducts = json_decode($ordernow->products, true);
    
                // สร้างคอลเล็กชันสำหรับรายละเอียดของสินค้า
                $productDetails = collect();
    
                foreach ($orderedProducts as $product) {
                    $productDetail = Product::find($product['id']);
                    if ($productDetail) {
                        $productDetail->quantity = $product['quantity']; // เพิ่มข้อมูลจำนวนสินค้า
                        $productDetails->push($productDetail);
                    } else {
                        // กรณีไม่พบข้อมูลสินค้า
                        $productDetails->push((object)[
                            'product_name' => 'ไม่พบข้อมูลสินค้า',
                            'quantity' => $product['quantity']
                        ]);
                    }
                }
    
                // ดึงข้อมูล employee และ supplier ตาม ID ที่ได้จาก order
                $employee = EmployeeInformation::find($ordernow->employee_id);
                $supplier = SupplierInformation::find($ordernow->supplier_id);
            }
        }
    
        // กำหนดวันที่ปัจจุบันให้กับ received_date ถ้าไม่มีการตั้งค่า
        $currentDate = now()->format('Y-m-d');
    
        return view('receiveproduct.receiveproducts', compact('receiveproducts', 'ordernow', 'productDetails', 'employee', 'supplier', 'currentDate'));
    }    
      

    public function create(Request $request) {
        // ดึงข้อมูลใบสั่งซื้อทั้งหมดจากตาราง ordernows
        $searchTerm = $request->input('search'); // รับค่าการค้นหาจาก request
    
        // ตรวจสอบว่าใช้การค้นหาหรือไม่
        if ($searchTerm) {
            // ใช้ Scout หรือการค้นหาปกติ
            $orders = Ordernow::with(['supplier', 'employee'])
                ->where('id', 'like', "%{$searchTerm}%")
                ->orWhere('order_date', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_id', 'like', "%{$searchTerm}%")
                ->orWhereHas('employee', function($query) use ($searchTerm) {
                    $query->where('employee_firstname', 'like', "%{$searchTerm}%")
                          ->orWhere('employee_lastname', 'like', "%{$searchTerm}%");
                })
                ->paginate(5); // แบ่งผลลัพธ์เป็นหน้า
        } else {
            // หากไม่มีการค้นหา ให้ดึงข้อมูลทั้งหมด
            $orders = Ordernow::with(['supplier', 'employee'])->paginate(5); 
        }
    
        // ดึงข้อมูลผู้จัดจำหน่ายทั้งหมด
        $suppliers = SupplierInformation::all();
        
        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();
    
        // ส่งข้อมูลไปยัง view receiveproduct.create
        return view('receiveproduct.create', compact('orders', 'suppliers', 'employees'));
    }
    

    public function store(Request $request) {
        // ตรวจสอบข้อมูลที่จำเป็น
        $validatedData = $request->validate([
            'order_id' => 'required|exists:ordernows,id',
            'order_date' => 'required|date',
            'received_date' => 'required|date',
            'employee_id' => 'required|exists:employee_information,id',
            'supplier_id' => 'required|exists:supplier_information,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.ordered_quantity' => 'required|numeric|min:0',
            'products.*.received_quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'total_price_at_received_date' => 'required|numeric',
        ]);
        
        // แปลงค่าจาก string เป็น int
        $products = array_map(function ($product) {
            return [
                'id' => $product['id'],
                'ordered_quantity' => (int) $product['ordered_quantity'],
                'received_quantity' => (int) $product['received_quantity'],
            ];
        }, $validatedData['products']);
        
        // สร้างข้อมูลการรับสินค้า
        $receiveproduct = new ReceiveProduct;
        $receiveproduct->order_id = $validatedData['order_id'];
        $receiveproduct->order_date = $validatedData['order_date'];
        $receiveproduct->received_date = $validatedData['received_date'];
        $receiveproduct->employee_id = $validatedData['employee_id'];
        $receiveproduct->supplier_id = $validatedData['supplier_id'];
        $receiveproduct->total_price = $validatedData['total_price'];
        $receiveproduct->total_price_at_received_date = $validatedData['total_price_at_received_date'];
        
        // Encode ข้อมูลสินค้าเป็น JSON และตรวจสอบว่า JSON ถูก encode ถูกต้อง
        $productsJson = json_encode($products);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'ข้อมูล JSON ไม่ถูกต้อง: ' . json_last_error_msg()], 422);
        }
        $receiveproduct->products = $productsJson;
    
        $receiveproduct->save();
    
        // เพิ่มข้อมูลในตาราง inventories
        foreach ($products as $product) {
            $inventory = Inventory::where('product_id', $product['id'])->first();
            
            if ($inventory) {
                // อัพเดตจำนวนที่มีอยู่แล้ว
                $inventory->amount += $product['received_quantity'];
                $inventory->save();
            }
        }
    
        // ลบข้อมูลใบสั่งซื้อหลังจากบันทึกการรับสินค้า
        $orderNow = OrderNow::find($validatedData['order_id']);
        if ($orderNow) {
            $orderNow->delete();
        }
    
        if ($request->ajax()) {
            return response()->json(['success' => 'เพิ่มข้อมูลการรับสินค้าเรียบร้อยแล้ว'], 200);
        }
    
        return redirect()->route('receiveproduct.receiveproducts')->with('success', 'เพิ่มข้อมูลการรับสินค้าเรียบร้อยแล้ว');
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
    
}
