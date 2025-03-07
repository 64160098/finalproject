<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\InventoryReport;
use App\Models\EmployeeInformation;

class InventoryReportController extends Controller
{

    // Create Index
    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');

        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $inventoryreports = InventoryReport::where('employee_id', 'like', "%{$searchTerm}%")
                ->orWhere('total_inventory_value', 'like', "%{$searchTerm}%")
                ->orWhere('transaction_date', 'like', "%{$searchTerm}%")
                ->orWhereHas('employee', function ($query) use ($searchTerm) {
                    $query->where('employee_firstname', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('employee', function ($query) use ($searchTerm) {
                    $query->where('employee_lastname', 'like', "%{$searchTerm}%");
                })
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $inventoryreports = InventoryReport::with('employee')
                ->orderBy('id', 'asc')
                ->paginate(5);
        }

        return view('inventoryreport.inventoryreports', [
            'inventoryreports' => $inventoryreports
        ]);
    }

    // Create resource
    public function create() {
        $currentDate = now()->format('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ YYYY-MM-DD
        $employees = EmployeeInformation::all(); // ดึงข้อมูลพนักงานทั้งหมดจากตาราง
        $products = Product::all();
        return view('inventoryreport.create', [
            'currentDate' => $currentDate,
            'employees' => $employees,
            'products' => $products,
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

    public function store(Request $request) {
        // Validate the request data
        $request->validate([
            'transaction_date' => 'required|date',
            'employee_id' => 'required|numeric',
            'selected_products' => 'required|json', // ตรวจสอบว่า selected_products เป็น JSON
        ]);
    
        // คำนวณราคารวมและตรวจสอบจำนวนสินค้า
        $selectedProducts = json_decode($request->input('selected_products'), true);
        $totalPrice = 0;
        $errors = [];
        
        foreach ($selectedProducts as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];
    
            // ค้นหาราคาแต่ละสินค้าจากฐานข้อมูลหรือที่ใดก็ตาม
            $productData = Product::find($productId);
            if ($productData) {
                $price = $productData->price;
                $totalPrice += $price * $quantity;
            } else {
                $errors[] = "ไม่พบข้อมูลสินค้าสำหรับ ID $productId";
                continue;
            }
        }
    
        // บันทึกข้อมูลลงฐานข้อมูล
        $inventoryreport = new InventoryReport();
        $inventoryreport->transaction_date = $request->input('transaction_date');
        $inventoryreport->employee_id = $request->input('employee_id');
        $inventoryreport->inventory_report_data = $request->input('selected_products'); // บันทึกข้อมูลสินค้าที่เลือกในรูปแบบ JSON
        $inventoryreport->total_inventory_value = $totalPrice; // บันทึกราคารวม
        $inventoryreport->save();
    
        return response()->json(['message' => 'รายงานสินค้าคงเหลือเรียบร้อยแล้ว'], 200);
    }    
    

    public function edit($id) {

        $inventoryreport = InventoryReport::findOrFail($id);

        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();

        // ดึงข้อมูลผลิตภัณฑ์ทั้งหมด
        $products = Product::all();

        // ดึงข้อมูลสินค้าที่เลือกในคำสั่งซื้อ
        $selectedProducts = json_decode($inventoryreport->inventory_report_data, true);
        
        // ส่งข้อมูลไปยังวิว
        return view('inventoryreport.edit', [
            'inventoryreport' => $inventoryreport,
            'currentDate' => $inventoryreport->transaction_date,
            'employees' => $employees,
            'products' => $products,
            'selectedEmployeeId' => $inventoryreport->employee_id,
            'selectedProducts' => $selectedProducts, // ข้อมูลสินค้าที่เลือก
            'id' => $id // ส่ง $id ไปยังวิว
        ]);
    }


    public function update(Request $request, $id) {
        // Validate and store the data
        $request->validate([
            'transaction_date' => 'required|date',
            'employee_id' => 'required|numeric',
            'selected_products' => 'required|json', // ตรวจสอบว่า selected_products เป็น JSON
        ]);

        $inventoryreport = InventoryReport::findOrFail($id);

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
    
        // อัปเดตข้อมูลรายการสินค้า
        $inventoryreport->transaction_date = $request->input('transaction_date');
        $inventoryreport->employee_id = $request->input('employee_id');
        $inventoryreport->inventory_report_data = $request->input('selected_products'); // อัปเดตข้อมูลสินค้าที่เลือกในรูปแบบ JSON
        $inventoryreport->total_inventory_value = $totalPrice;
        $inventoryreport->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('inventoryreport.inventoryreports')->with('success', 'แก้ไขรายงานการขายสินค้าเรียบร้อยแล้ว');
    }    
    

    public function destroy(InventoryReport $inventoryreport) {
        $inventoryreport->delete();
        return response()->json(['success' => 'ลบข้อมูลเรียบร้อยแล้ว'], 200);
    }

    public function showInventoryReportDetails($inventoryreportId) {
        // ดึงข้อมูลรายงานการขายสินค้าโดยใช้ ID
        $inventoryreport = InventoryReport::find($inventoryreportId);
    
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!$inventoryreport) {
            return redirect()->route('inventoryreport.inventoryreports')->with('error', 'Report not found.');
        }
    
        // ดึงข้อมูลพนักงาน
        $employee = EmployeeInformation::find($inventoryreport->employee_id);
    
        // ตรวจสอบว่ามีข้อมูลพนักงานหรือไม่
        if (!$employee) {
            return redirect()->route('productsalereport.productsalereports')->with('error', 'Employee not found.');
        }
    
        // Decode ข้อมูลสินค้าในรูปแบบ JSON
        $orderedProducts = json_decode($inventoryreport->inventory_report_data, true);
    
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
        return view('inventoryreport.detailinventoryreport', compact('inventoryreport', 'employee', 'productDetails'));
    }

}
