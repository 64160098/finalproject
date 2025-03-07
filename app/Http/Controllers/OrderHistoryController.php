<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderHistory;
use App\Models\ReceiveProduct;
use App\Models\Inventory;
use App\Models\SupplierInformation;
use App\Models\EmployeeInformation;
use App\Models\Ordernow;
use App\Models\Product;

class OrderHistoryController extends Controller
{

    public function index(Request $request) {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = $request->input('search');
    
        // ใช้ Scout ในการค้นหา
        if ($searchTerm) {
            $orderhistorys = ReceiveProduct::where('order_id', 'like', "%{$searchTerm}%")
                ->orWhere('received_date', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_id', 'like', "%{$searchTerm}%")
                ->orWhere('employee_id', 'like', "%{$searchTerm}%")
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $orderhistorys = ReceiveProduct::orderBy('order_id', 'asc')->paginate(5);
        }
    
        // สร้าง array เพื่อเก็บสถานะของแต่ละ order_id
        $statuses = [];
    
        foreach ($orderhistorys as $orderhistory) {
            $order_id = $orderhistory->order_id;
    
            // ดึงข้อมูลการสั่งซื้อจากตาราง ordernows
            $orderNow = ReceiveProduct::find($order_id);
    
            if ($orderNow) {
                // ดึงข้อมูลการรับสินค้าจากตาราง receive_products
                $receiveproduct = ReceiveProduct::where('order_id', $order_id)->first();
    
                if ($receiveproduct) {
                    // Decode ข้อมูลสินค้าในรูปแบบ JSON จาก orderNow
                    $orderedProducts = json_decode($orderNow->products, true);
                    $receivedProducts = json_decode($receiveproduct->products, true);
    
                    // สร้างอาร์เรย์เพื่อเก็บข้อมูลจำนวนสินค้า
                    $orderedProductsMap = [];
                    $receivedProductsMap = [];
    
                    // เตรียมข้อมูลการสั่งซื้อ
                    foreach ($orderedProducts as $product) {
                        if (isset($product['ordered_quantity'])) {
                            $orderedProductsMap[$product['id']] = [
                                'ordered_quantity' => $product['ordered_quantity']
                            ];
                        } else {
                            // จัดการกรณีที่ไม่มี 'ordered_quantity'
                            $orderedProductsMap[$product['id']] = [
                                'ordered_quantity' => 0 // หรือค่าที่เหมาะสม
                            ];
                        }
                    }
                    
                    foreach ($receivedProducts as $product) {
                        if (isset($product['received_quantity'])) {
                            $receivedProductsMap[$product['id']] = [
                                'received_quantity' => $product['received_quantity']
                            ];
                        } else {
                            // จัดการกรณีที่ไม่มี 'received_quantity'
                            $receivedProductsMap[$product['id']] = [
                                'received_quantity' => 0 // หรือค่าที่เหมาะสม
                            ];
                        }
                    }
    
                    // ตรวจสอบจำนวนสินค้าว่าตรงกับจำนวนที่สั่งหรือไม่
                    $status = 'เสร็จสมบูรณ์';
                    foreach ($orderedProductsMap as $productId => $orderedData) {
                        if (isset($receivedProductsMap[$productId])) {
                            $orderedQuantity = $orderedData['ordered_quantity'];
                            $receivedQuantity = $receivedProductsMap[$productId]['received_quantity'];
                            if ($orderedQuantity != $receivedQuantity) {
                                $status = 'สินค้าไม่ครบ';
                                break;
                            }
                        } else {
                            $status = 'สินค้าไม่ครบ';
                            break;
                        }
                    }
    
                    $statuses[$order_id] = $status;
                } else {
                    $statuses[$order_id] = 'ข้อมูลไม่พบ';
                }
            } else {
                $statuses[$order_id] = 'ข้อมูลไม่พบ';
            }
        }
    
        // ส่งข้อมูลไปยัง view
        return view('orderhistory.orderhistorys', [
            'orderhistorys' => $orderhistorys,
            'statuses' => $statuses
        ]);
    }    

    public function destroy(ReceiveProduct $orderhistory) {
        $orderhistory->delete();
        return response()->json(['success' => 'ประวัติการรับสินค้าเข้าคลังถูกลบเรียบร้อยแล้ว'], 200);
    }

    public function detailorderhistory($order_id) {
        // ดึงข้อมูลใบสั่งซื้อจากตาราง ordernows ที่ตรงกับ id ที่ผู้ใช้เรียก
        $orderNow = ReceiveProduct::findOrFail($order_id);
    
        // ดึงข้อมูลใบสั่งซื้อจากตาราง receive_products ที่ตรงกับ order_id
        $receiveproducts = ReceiveProduct::with(['supplier', 'employee'])
            ->where('order_id', $order_id)
            ->firstOrFail(); // ใช้ firstOrFail เพื่อให้เกิดข้อผิดพลาดหากไม่พบข้อมูล
    
        // ดึงข้อมูลผู้จัดจำหน่ายที่ตรงกับ id ที่พบ
        $supplier = SupplierInformation::find($orderNow->supplier_id);
    
        // ดึงข้อมูลพนักงานที่ตรงกับ id ที่พบ
        $employee = EmployeeInformation::find($orderNow->employee_id);
    
        // Decode ข้อมูลสินค้าในรูปแบบ JSON จาก orderNow
        $orderedProducts = json_decode($receiveproducts->products, true);
    
        // สร้างอาร์เรย์เพื่อเก็บรายละเอียดสินค้า
        $productDetails = [];
    
        foreach ($orderedProducts as $product) {
            $productDetail = Product::find($product['id']);
            if ($productDetail) {
                $productDetail->ordered_quantity = $product['ordered_quantity']; // เพิ่มข้อมูลจำนวนสินค้า
                $productDetail->received_quantity = $product['received_quantity']; // เพิ่มข้อมูลจำนวนสินค้า
                $productDetails[] = $productDetail;
            } else {
                // กรณีไม่พบข้อมูลสินค้า
                $productDetails[] = (object)[
                    'product_name' => 'ไม่พบข้อมูลสินค้า',
                    'ordered_quantity' => $product['ordered_quantity'],
                    'received_quantity' => $product['received_quantity'],
                ];
            }
        }
    
        // ส่งข้อมูลไปยัง view
        return view('orderhistory.detailorderhistory', compact('receiveproducts', 'supplier', 'employee', 'orderNow', 'productDetails'));
    }

    public function edit($id) {

        $receiveproduct = ReceiveProduct::findOrFail($id);

        // ดึงข้อมูล employee และ supplier ตาม ID ที่ได้จาก order
        $employee = EmployeeInformation::find($receiveproduct->employee_id);
        $supplier = SupplierInformation::find($receiveproduct->supplier_id);

        
        // ดึงข้อมูลผลิตภัณฑ์จาก JSON ที่เก็บไว้ในฟิลด์ products
        $orderedProducts = json_decode($receiveproduct->products, true);
        
        // สร้างคอลเล็กชันสำหรับรายละเอียดของสินค้า
        $productDetails = collect();
        
        if ($orderedProducts) {
            foreach ($orderedProducts as $product) {
                // ค้นหาข้อมูลผลิตภัณฑ์จากตาราง Product โดยใช้ product id
                $productDetail = Product::find($product['id']);
                
                if ($productDetail) {
                    // เพิ่มข้อมูลจำนวนสินค้าลงใน productDetail
                    $productDetail->ordered_quantity = $product['ordered_quantity'] ?? 0;
                    $productDetail->received_quantity = $product['received_quantity'] ?? 0;
                    $productDetail->price = $productDetail->price;  // สมมุติว่า price อยู่ในตาราง Product
    
                    // เก็บข้อมูลในคอลเล็กชัน
                    $productDetails->push($productDetail);
                } else {
                    // กรณีไม่พบข้อมูลสินค้าในตาราง Product
                    $productDetails->push((object)[
                        'product_name' => 'ไม่พบข้อมูลสินค้า',
                        'ordered_quantity' => $product['ordered_quantity'] ?? 0,
                        'received_quantity' => $product['received_quantity'] ?? 0
                    ]);
                }
            }
        }
    
        // ส่งข้อมูลไปยัง view
        return view('orderhistory.edit', compact('receiveproduct', 'supplier', 'employee', 'productDetails'));
    }
    
    public function update(Request $request, $order_id) {
        // ตรวจสอบข้อมูลที่จำเป็น
        $validatedData = $request->validate([
            'order_id' => 'required|exists:receive_products,order_id',
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
    
        // ค้นหาข้อมูลการรับสินค้าที่จะอัปเดต
        $receiveproduct = ReceiveProduct::find($order_id);
        if (!$receiveproduct) {
            return redirect()->route('receiveproduct.receiveproducts')->withErrors(['error' => 'ไม่พบข้อมูลการรับสินค้า']);
        }
    
        // อัปเดตข้อมูลการรับสินค้า
        $receiveproduct->order_id = $validatedData['order_id'];
        $receiveproduct->order_date = $validatedData['order_date'];
        $receiveproduct->received_date = $validatedData['received_date'];
        $receiveproduct->employee_id = $validatedData['employee_id'];
        $receiveproduct->supplier_id = $validatedData['supplier_id'];
        $receiveproduct->total_price = $validatedData['total_price'];
        $receiveproduct->total_price_at_received_date = $validatedData['total_price_at_received_date'];
    
        // Decode ข้อมูล JSON ของ products จากฐานข้อมูล
        $oldProducts = json_decode($receiveproduct->products, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'ข้อมูล JSON เก่าผิดพลาด: ' . json_last_error_msg()], 422);
        }
    
        // อัปเดตข้อมูลในตาราง inventories
        foreach ($products as $product) {
            $inventory = Inventory::where('product_id', $product['id'])->first();
    
            if ($inventory) {
                // คำนวณจำนวนที่ต้องปรับปรุงจากข้อมูลเก่าใน products
                $previousReceivedQuantity = $oldProducts[array_search($product['id'], array_column($oldProducts, 'id'))]['received_quantity'] ?? 0;
    
                // จำนวนที่ผู้ใช้ระบุในขณะนี้
                $currentReceivedQuantity = $product['received_quantity'];
    
                // คำนวณค่าความแตกต่าง
                $difference = $currentReceivedQuantity - $previousReceivedQuantity;
    
                // อัปเดตจำนวนใน inventory เฉพาะกรณีที่มีการเปลี่ยนแปลง
                if ($difference != 0) {
                    // ปรับปรุงจำนวนในคลังสินค้า
                    $inventory->amount += $difference;
                    // บันทึกการเปลี่ยนแปลงใน inventory
                    $inventory->save();
                }
            }
        }
    
        // Encode ข้อมูลสินค้าใหม่เป็น JSON และตรวจสอบว่า JSON ถูก encode ถูกต้อง
        $productsJson = json_encode($products);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'ข้อมูล JSON ใหม่ไม่ถูกต้อง: ' . json_last_error_msg()], 422);
        }
        $receiveproduct->products = $productsJson;
    
        // บันทึกการอัปเดต
        $receiveproduct->save();
    
        if ($request->ajax()) {
            return response()->json(['success' => 'อัปเดตข้อมูลการรับสินค้าเรียบร้อยแล้ว']);
        }
    
        return redirect()->route('orderhistory.orderhistorys')->with('alert', 'อัปเดตข้อมูลการรับสินค้าเรียบร้อยแล้ว');
    }
    
}
