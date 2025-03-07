<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductSalesHistory;
use App\Models\ProductSaleReport;
use App\Models\Product;
use App\Models\EmployeeInformation;
use Carbon\Carbon;

class ProductSalesHistoryController extends Controller
{

    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');

        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $productsalehistorys = ProductSaleReport::where('employee_id', 'like', "%{$searchTerm}%")
                ->orWhere('transaction_date', 'like', "%{$searchTerm}%")
                ->orWhere('total_sales', 'like', "%{$searchTerm}%")
                ->orWhereHas('employee', function ($query) use ($searchTerm) {
                    $query->where('employee_firstname', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('employee', function ($query) use ($searchTerm) {
                    $query->where('employee_lastname', 'like', "%{$searchTerm}%"); 
                })
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $productsalehistorys = ProductSaleReport::with('employee') // eager load employee
            ->orderBy('id', 'asc')
            ->paginate(5);
        }
    
        return view('productsalereport.productsalehistorys', [
            'productsalehistorys' => $productsalehistorys
        ]);
    }    

    public function edit($id) {

        $productsalereport = ProductSaleReport::findOrFail($id);

        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = EmployeeInformation::all();

        // ดึงข้อมูลผลิตภัณฑ์ทั้งหมด
        $products = Product::all();

        // ดึงข้อมูลสินค้าที่เลือกในคำสั่งซื้อ
        $selectedProducts = json_decode($productsalereport->products_sales, true);
        
        // ส่งข้อมูลไปยังวิว
        return view('productsalereport.adminedit', [
            'productsalereport' => $productsalereport,
            'currentDate' => $productsalereport->transaction_date,
            'employees' => $employees,
            'products' => $products,
            'selectedEmployeeId' => $productsalereport->employee_id,
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

        $productsalereport = ProductSaleReport::findOrFail($id);

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
        $productsalereport->transaction_date = $request->input('transaction_date');
        $productsalereport->employee_id = $request->input('employee_id');
        $productsalereport->products_sales = $request->input('selected_products'); // อัปเดตข้อมูลสินค้าที่เลือกในรูปแบบ JSON
        $productsalereport->total_sales = $totalPrice;
        $productsalereport->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('productsalereport.productsalehistorys')->with('success', 'แก้ไขรายงานการขายสินค้าเรียบร้อยแล้ว');
    }         

    public function showadminProductSaleDetails($productsalereportId) {
        // ดึงข้อมูลรายงานการขายสินค้าโดยใช้ ID
        $productsalereport = ProductSaleReport::find($productsalereportId);
    
        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if (!$productsalereport) {
            return redirect()->route('productsalereport.productsalereports')->with('error', 'Report not found.');
        }
    
        // ดึงข้อมูลพนักงาน
        $employee = EmployeeInformation::find($productsalereport->employee_id);
    
        // ตรวจสอบว่ามีข้อมูลพนักงานหรือไม่
        if (!$employee) {
            return redirect()->route('productsalereport.productsalereports')->with('error', 'Employee not found.');
        }
    
        // Decode ข้อมูลสินค้าในรูปแบบ JSON
        $orderedProducts = json_decode($productsalereport->products_sales, true);
    
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
        return view('productsalereport.detailproductsaleadmin', compact('productsalereport', 'employee', 'productDetails'));
    }   

}
