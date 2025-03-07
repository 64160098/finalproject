<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ordernow;
use App\Models\SupplierInformation;
use App\Models\EmployeeInformation;
use App\Models\Product;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdernowController extends Controller
{
    // Create Index
    public function index() {
            // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $ordernows = Ordernow::where('id', 'like', "%{$searchTerm}%")
                ->orWhere('order_date', 'like', "%{$searchTerm}%")
                ->orWhere('supplier_id', 'like', "%{$searchTerm}%")
                ->orWhereHas('employee', function($query) use ($searchTerm) {
                    $query->where('employee_firstname', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('employee', function($query) use ($searchTerm) {
                    $query->where('employee_lastname', 'like', "%{$searchTerm}%");
                })
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $ordernows = Ordernow::orderBy('id', 'asc')->paginate(5);
        }

        return view('ordernow.ordernows', ['ordernows' => $ordernows]);
    }


    public function createstep1()
    {
        do {
            // สร้างเลขสุ่ม 8 หลักที่ไม่ซ้ำ
            $id = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        } while (Ordernow::where('id', $id)->exists()); // ตรวจสอบว่าเลขนี้มีอยู่แล้วในฐานข้อมูล
    
        // ดึงข้อมูลจากเซสชัน
        $orderDate = session('order_date', now()->format('Y-m-d'));
        $supplierId = session('supplier_id');
        $employeeId = session('employee_id');
        
        // ดึงข้อมูลผู้จัดจำหน่ายทั้งหมด
        $suppliers = SupplierInformation::all();
        
        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();
        
        // ดึงรายละเอียดของผู้ขายและพนักงานจากเซสชัน
        $selectedSupplier = $supplierId ? SupplierInformation::find($supplierId) : null;
        $selectedEmployeeId = $employeeId; // ใช้ตัวแปรนี้แทน
    
        // ส่งข้อมูลไปยังวิว
        return view('ordernow.createstep1', [
            'id' => $id,
            'currentDate' => $orderDate,
            'suppliers' => $suppliers,
            'employees' => $employees,
            'selectedSupplierId' => $supplierId,
            'selectedEmployeeId' => $selectedEmployeeId, // ส่งตัวแปรนี้ไปยังวิว
        ]);
    }      

    public function postStep1(Request $request) {
        // Validate and store the data
        $request->validate([
            'order_date' => 'required|date',
            'supplier_id' => 'required|exists:supplier_information,id',
            'employee_id' => 'required|exists:employee_information,id',
        ]);
    
        // Store the 8-digit order number in the session
        $id = $request->input('id'); // ใช้ 'id' แทน 'order_number'
        
        // Store data in session
        session([
            'id' => $id, // Store the 8-digit order number
            'order_date' => $request->order_date,
            'supplier_id' => $request->supplier_id,
            'employee_id' => $request->employee_id,
        ]);
    
        return redirect()->route('ordernow.createstep2');
    }       
    
    public function createstep2()
    {
        $id = session('id');
        $orderDate = session('order_date');
        $supplierId = session('supplier_id');
        $employeeId = session('employee_id');

        $products = Product::all();
        $suppliers = SupplierInformation::all(); // Adjust as needed
        $employees = EmployeeInformation::all(); // Adjust as needed
        $currentDate = now()->toDateString();
        
        return view('ordernow.createstep2', compact('id', 'orderDate', 'supplierId', 'employeeId', 'suppliers', 'employees', 'currentDate', 'products'));
    }     

    public function postStep2(Request $request) {
        // Validate and store the data
        $request->validate([
            'id' => 'required|numeric|digits:8',
            'order_date' => 'required|date',
            'supplier_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'selected_products' => 'required|json', // ตรวจสอบว่า selected_products เป็น JSON
        ]);
    
        // คำนวณราคารวม
        $selectedProducts = json_decode($request->input('selected_products'), true);
        $totalPrice = 0;
        foreach ($selectedProducts as $product) {
            // ค้นหาราคาแต่ละสินค้าจากฐานข้อมูลหรือที่ใดก็ตาม
            $productId = $product['id'];
            $quantity = $product['quantity'];
    
            // สมมติว่ามี Model Product หรือวิธีการดึงข้อมูลราคาสินค้า
            $productData = Product::find($productId);
            if ($productData) {
                $price = $productData->price;
                $totalPrice += $price * $quantity;
            }
        }
    
        // Save order to the database
        $order = new Ordernow();
        $order->id = $request->input('id');
        $order->order_date = $request->input('order_date');
        $order->supplier_id = $request->input('supplier_id');
        $order->employee_id = $request->input('employee_id');
        $order->products = $request->input('selected_products'); // บันทึกข้อมูลสินค้าที่เลือกในรูปแบบ JSON
        $order->total_price = $totalPrice; // บันทึกราคารวม
        $order->save();
    
        return redirect()->route('ordernow.ordernows')->with('success', 'Order created successfully!');
    }  
    
    public function editStep1($id) {
        // ดึงข้อมูลการสั่งซื้อจากฐานข้อมูล
        $order = Ordernow::findOrFail($id);
        
        // ดึงข้อมูลผู้จัดจำหน่ายทั้งหมด
        $suppliers = SupplierInformation::all();
        
        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();
        
        // ส่งข้อมูลไปยังวิว
        return view('ordernow.editstep1', [
            'order' => $order,
            'id' => $id, // ส่ง $id ไปยังวิว
            'currentDate' => $order->order_date,
            'suppliers' => $suppliers,
            'employees' => $employees,
            'selectedSupplierId' => $order->supplier_id,
            'selectedEmployeeId' => $order->employee_id,
        ]);
    }
    

    public function updateStep1(Request $request, $id) {
        // Validate and store the data
        $request->validate([
            'order_date' => 'required|date',
            'supplier_id' => 'required|exists:supplier_information,id',
            'employee_id' => 'required|exists:employee_information,id',
        ]);
        
        $order = Ordernow::findOrFail($id);
        
        // อัปเดตข้อมูลในฐานข้อมูล
        $order->order_date = $request->order_date;
        $order->supplier_id = $request->supplier_id;
        $order->employee_id = $request->employee_id;
        $order->save();
        
        // เก็บข้อมูลในเซสชันเพื่อใช้ในขั้นตอนถัดไป
        session([
            'order_date' => $request->order_date,
            'supplier_id' => $request->supplier_id,
            'employee_id' => $request->employee_id,
        ]);
        
        return redirect()->route('ordernow.editstep2', ['id' => $id]);
    }
    

    public function editStep2($id) {
        $order = Ordernow::findOrFail($id);
    
        // ดึงข้อมูลสินค้าทั้งหมด
        $products = Product::all();
        
        // ดึงข้อมูลผู้จัดจำหน่ายทั้งหมด
        $suppliers = SupplierInformation::all();
        
        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();
        
        // กำหนดวันที่ปัจจุบัน
        $currentDate = now()->toDateString();
        
        // ดึงข้อมูลสินค้าที่เลือกในคำสั่งซื้อ
        $selectedProducts = json_decode($order->products, true);
    
        // ส่งข้อมูลไปยังวิว
        return view('ordernow.editstep2', [
            'order' => $order,
            'products' => $products,
            'suppliers' => $suppliers,
            'employees' => $employees,
            'currentDate' => $currentDate,
            'selectedProducts' => $selectedProducts, // ข้อมูลสินค้าที่เลือก
            'id' => $id // ส่ง $id ไปยังวิว
        ]);
    }     

    public function updateStep2(Request $request, $id) {
    // Validate and store the data
    $request->validate([
        'id' => 'required|numeric|digits:8',
        'order_date' => 'required|date',
        'supplier_id' => 'required|numeric',
        'employee_id' => 'required|numeric',
        'selected_products' => 'required|json', // ตรวจสอบว่า selected_products เป็น JSON
    ]);
    
    $order = Ordernow::findOrFail($id);
    
    // คำนวณราคารวม
    $selectedProducts = json_decode($request->input('selected_products'), true);
    $totalPrice = 0;
    foreach ($selectedProducts as $product) {
        $productId = $product['id'];
        $quantity = $product['quantity'];
        
        $productData = Product::find($productId);
        if ($productData) {
            $price = $productData->price;
            $totalPrice += $price * $quantity;
        }
    }
    
    // อัปเดตข้อมูลในฐานข้อมูล
    $order->order_date = $request->input('order_date');
    $order->supplier_id = $request->input('supplier_id');
    $order->employee_id = $request->input('employee_id');
    $order->products = $request->input('selected_products'); // อัปเดตข้อมูลสินค้าที่เลือกในรูปแบบ JSON
    $order->total_price = $totalPrice; // อัปเดตราคารวม
    $order->save();
    
    return redirect()->route('ordernow.ordernows')->with('success', 'Order updated successfully!');
    }



    public function getSupplierDetails($id) {
        // ดึงข้อมูลจากตาราง supplier_information โดยใช้ find
        $supplier = SupplierInformation::find($id);
    
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    
        return response()->json([
            'supplier' => [
                'id' => $supplier->id,
                'name' => $supplier->supplier_name,
                'customer_name' => $supplier->supplier_customer_name,
                'product' => $supplier->supplier_product,
                'contact_number' => $supplier->supplier_contact_number,
                'email' => $supplier->supplier_email,
            ],
        ]);
    }    

    public function getEmployeeDetails($id)
    {
        // ดึงข้อมูลจากตาราง employee_information
        $employee = EmployeeInformation::find($id);
    
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        return response()->json([
            'employee' => [
                'id' => $employee->id,
                'firstname' => $employee->employee_firstname,
                'lastname' => $employee->employee_lastname,
                'contact_number' => $employee->employee_contact_number,
                'email' => $employee->employee_email,
                'status' => $employee->employee_status,
            ],
        ]);
    }
    
    public function showOrderDetails($orderId) {
        // ดึงข้อมูล order โดยใช้ ID
        $ordernow = Ordernow::find($orderId);
    
        // ตรวจสอบว่ามีข้อมูล order หรือไม่
        if (!$ordernow) {
            return redirect()->route('order.ordernows')->with('error', 'Order not found.');
        }
    
        // ดึงข้อมูล employee และ supplier ตาม ID ที่ได้จาก order
        $employee = EmployeeInformation::find($ordernow->employee_id);
        $supplier = SupplierInformation::find($ordernow->supplier_id);
    
        // ตรวจสอบว่ามีข้อมูล employee และ supplier หรือไม่
        if (!$employee) {
            return redirect()->route('orders.ordernows')->with('error', 'Employee not found.');
        }
    
        if (!$supplier) {
            return redirect()->route('orders.ordernows')->with('error', 'Supplier not found.');
        }
    
        // Decode ข้อมูลสินค้าในรูปแบบ JSON
        $orderedProducts = json_decode($ordernow->products, true);
    
        // สร้างอาร์เรย์เพื่อเก็บรายละเอียดสินค้า
        $productDetails = [];
    
        foreach ($orderedProducts as $product) {
            $productDetail = Product::find($product['id']);
            if ($productDetail) {
                $productDetail->quantity = $product['quantity']; // เพิ่มข้อมูลจำนวนสินค้า
                $productDetails[] = $productDetail;
            } else {
                // กรณีไม่พบข้อมูลสินค้า
                $productDetails[] = (object)[
                    'product_name' => 'ไม่พบข้อมูลสินค้า',
                    'quantity' => $product['quantity']
                ];
            }
        }
    
        // ส่งข้อมูลไปยัง view
        return view('ordernow.detailorder', compact('ordernow', 'employee', 'supplier', 'productDetails'));
    } 
    
    public function destroy(Ordernow $ordernow) {
        $ordernow->delete();
        return response()->json(['success' => 'ข้อมูลใบสั่งซื้อถูกลบเรียบร้อยแล้ว'], 200);
    }
    
    public function generateorderPDF($id)
    {
        // ดึงข้อมูลจาก ordernows โดยใช้ ID
        $order = Ordernow::find($id);
    
        if (!$order) {
            abort(404, 'ข้อมูลไม่พบ');
        }
    
        // ดึงข้อมูลของ supplier, employee, และ products ที่เกี่ยวข้องกับ order นี้
        $supplier = SupplierInformation::find($order->supplier_id);
        $employee = EmployeeInformation::find($order->employee_id);
        $products = json_decode($order->products, true); // แปลงข้อมูลผลิตภัณฑ์จาก JSON เป็น array
    
        // ดึงรายละเอียดของผลิตภัณฑ์จากตาราง products โดยใช้ id ของสินค้าที่สั่งซื้อ
        $productDetails = Product::whereIn('id', array_column($products, 'id'))->get();
    
        // เตรียมข้อมูลที่จะส่งไปที่มุมมอง
        $data = [
            'title' => 'รายละเอียดการสั่งซื้อและจุดสั่งซ้ำ',
            'order' => $order,
            'supplier' => $supplier,
            'employee' => $employee,
            'products' => $productDetails,
            'orderedProducts' => $products, // เก็บข้อมูลผลิตภัณฑ์ที่สั่ง
        ];
    
        // ตั้งค่าฟอนต์
        Pdf::setOptions([
            'font_dir' => public_path('fonts'),
            'font_cache' => storage_path('fonts'),
            'default_font' => 'THSarabun', // ใช้ชื่อฟอนต์ที่ถูกต้อง
        ]);
    
        // สร้าง PDF จากมุมมองที่ต้องการ
        $pdf = Pdf::loadView('ordernow.detailorderpdf', $data);
        
        return $pdf->stream('ใบสั่งซื้อ.pdf');
    }    
    
}
