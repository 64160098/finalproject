<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductSaleReport;
use App\Models\Product;
use App\Models\EmployeeInformation;
use App\Models\Inventory;
use Carbon\Carbon;

class ProductSaleReportController extends Controller
{
    public function index() {
        $searchTerm = request('search');

        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $productsalereports = ProductSaleReport::where('employee_id', 'like', "%{$searchTerm}%")
                ->orWhere('total_sales', 'like', "%{$searchTerm}%")
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
            $productsalereports = ProductSaleReport::with('employee')
                ->orderBy('id', 'asc')
                ->paginate(5);
        }
    
        return view('productsalereport.productsalereports', [
            'productsalereports' => $productsalereports
        ]);
    }    

    // Create resource
    public function create() {
        $currentDate = now()->format('Y-m-d'); // วันที่ปัจจุบันในรูปแบบ YYYY-MM-DD
        $employees = EmployeeInformation::all(); // ดึงข้อมูลพนักงานทั้งหมดจากตาราง
        $products = Product::all();
    
        return view('productsalereport.create', [
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
    
            // ตรวจสอบจำนวนสินค้าที่มีอยู่ในคลัง
            $inventory = Inventory::where('product_id', $productId)->first();
            if ($inventory) {
                if ($quantity > $inventory->amount) {
                    // หากจำนวนที่รายงานมากกว่าจำนวนที่มีในคลัง
                    $errors[] = "สินค้า ID $productId มีจำนวนในคลังไม่เพียงพอ (มี $inventory->amount ชิ้น)";
                }
            } else {
                // หากไม่พบสินค้าดังกล่าวในคลัง
                $errors[] = "ไม่พบข้อมูลสินค้าสำหรับ ID $productId ในคลัง";
            }
        }
    
        // หากมีข้อผิดพลาด
        if (!empty($errors)) {
            return response()->json(['message' => implode(' | ', $errors)], 400);
        }
    
        // บันทึกข้อมูลลงฐานข้อมูล
        $productsalereport = new ProductSaleReport();
        $productsalereport->transaction_date = $request->input('transaction_date');
        $productsalereport->employee_id = $request->input('employee_id');
        $productsalereport->products_sales = $request->input('selected_products'); // บันทึกข้อมูลสินค้าที่เลือกในรูปแบบ JSON
        $productsalereport->total_sales = $totalPrice; // บันทึกราคารวม
        $productsalereport->save();
    
        // อัปเดตคลังสินค้า
        foreach ($selectedProducts as $product) {
            $productId = $product['id'];
            $quantity = $product['quantity'];
    
            // อัปเดตคลังสินค้า
            $inventory = Inventory::where('product_id', $productId)->first();
            if ($inventory) {
                $inventory->amount -= $quantity;
                $inventory->save();
            }
        }
    
        return response()->json(['message' => 'รายงานการขายสินค้าเรียบร้อยแล้ว'], 200);
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
        return view('productsalereport.edit', [
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
        $errors = [];
    
        // เก็บข้อมูลสินค้าที่ถูกขายก่อนหน้า
        $oldSelectedProducts = json_decode($productsalereport->products_sales, true);
    
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
    
            // ตรวจสอบจำนวนสินค้าที่มีอยู่ในคลัง
            $inventory = Inventory::where('product_id', $productId)->first();
            if ($inventory) {
                // คำนวณจำนวนที่ต้องปรับปรุงจากข้อมูลเก่าใน selected_products
                $oldQuantity = $oldSelectedProducts[array_search($productId, array_column($oldSelectedProducts, 'id'))]['quantity'] ?? 0; // จำนวนเก่า
    
                // จำนวนที่ผู้ใช้ระบุในขณะนี้
                $currentQuantity = $quantity;
    
                // คำนวณค่าความแตกต่าง
                $difference = $currentQuantity - $oldQuantity;
    
                // อัปเดตจำนวนใน inventory เฉพาะกรณีที่มีการเปลี่ยนแปลง
                if ($difference != 0) {
                    // ปรับปรุงจำนวนในคลังสินค้า
                    if ($inventory->amount + $difference >= 0) {
                        $inventory->amount -= $difference; // ปรับลดจำนวนตามความแตกต่าง
                        $inventory->save();
                    } else {
                        $errors[] = "สินค้า ID $productId มีจำนวนในคลังไม่เพียงพอ (มี $inventory->amount ชิ้น)";
                    }
                }
            } else {
                $errors[] = "ไม่พบข้อมูลสินค้าสำหรับ ID $productId ในคลัง";
            }
        }
    
        // หากมีข้อผิดพลาด
        if (!empty($errors)) {
            return response()->json(['message' => implode(' | ', $errors)], 400);
        }
    
        // อัปเดตข้อมูลรายการสินค้า
        $productsalereport->transaction_date = $request->input('transaction_date');
        $productsalereport->employee_id = $request->input('employee_id');
        $productsalereport->products_sales = $request->input('selected_products'); // อัปเดตข้อมูลสินค้าที่เลือกในรูปแบบ JSON
        $productsalereport->total_sales = $totalPrice; // อัปเดตราคารวม
        $productsalereport->save();
    
        // ส่งกลับไปยังหน้าที่เหมาะสมหลังจากการบันทึกข้อมูลเรียบร้อยแล้ว
        return redirect()->route('productsalereport.productsalereports')->with('success', 'แก้ไขรายงานการขายสินค้าเรียบร้อยแล้ว');
    }
                
    

    public function destroy(ProductSaleReport $productsalereport) {
        // ลบรายงานการขายสินค้า
        $productsalereport->delete();
        return response()->json(['success' => 'ลบข้อมูลรายงานการขายสินค้าเรียบร้อยแล้ว'], 200);
    }
    

    public function showProductSaleDetails($productsalereportId) {
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
        return view('productsalereport.detailproductsale', compact('productsalereport', 'employee', 'productDetails'));
    }

    public function show(Request $request)
    {
        // รับค่าปีและเดือนจากคำขอ, หรือกำหนดเป็นปีและเดือนปัจจุบันถ้าไม่ได้รับค่า
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);
        
        // สร้างอาร์เรย์ของชื่อเดือนภาษาไทย
        $thaiMonths = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม'
        ];
    
        // ฟังก์ชันสำหรับรวมข้อมูลยอดขาย
        $aggregateSalesData = function ($sales) {
            $aggregatedSales = [];
            foreach ($sales as $sale) {
                $products = json_decode($sale->products_sales, true); // แปลง JSON เป็น Array
                if (is_array($products)) {
                    foreach ($products as $product) {
                        $productId = $product['id'];
                        $quantity = $product['quantity'];
    
                        // ตรวจสอบว่ามีสินค้าชนิดนี้อยู่ในรายการรวมแล้วหรือยัง
                        if (isset($aggregatedSales[$productId])) {
                            // ถ้ามีอยู่แล้ว ให้รวมจำนวนสินค้า
                            $aggregatedSales[$productId]['quantity'] += $quantity;
                        } else {
                            // ถ้าไม่มี ให้สร้างรายการใหม่
                            $aggregatedSales[$productId] = [
                                'quantity' => $quantity,
                            ];
                        }
                    }
                }
            }
            return $aggregatedSales;
        };
    
        // ดึงข้อมูลยอดขายตามเดือน
        $monthlySales = ProductSaleReport::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->get();
    
        // รวมข้อมูลยอดขายรายเดือน
        $aggregatedMonthlySales = $aggregateSalesData($monthlySales);
    
        // ดึงข้อมูลยอดขายตามปี (สำหรับสรุปรายปี)
        $yearlySales = ProductSaleReport::whereYear('transaction_date', $year)->get();
    
        // รวมข้อมูลยอดขายรายปี
        $aggregatedYearlySales = $aggregateSalesData($yearlySales);
    
        // ดึงข้อมูลสินค้าจากตาราง products โดยใช้ product ID (ทั้งรายเดือนและรายปี)
        $productIds = array_unique(array_merge(array_keys($aggregatedMonthlySales), array_keys($aggregatedYearlySales)));
        $productDetails = Product::with('productUnit')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');
    
        // รวบรวมข้อมูลสุดท้ายที่จะแสดงในตารางรายเดือน
        $finalMonthlySalesData = collect($aggregatedMonthlySales)->map(function ($sale, $productId) use ($productDetails) {
            $product = $productDetails->get($productId);
            return [
                'product_id' => $productId,
                'product_name' => $product ? $product->product_name : 'ไม่ทราบชื่อสินค้า',
                'quantity' => $sale['quantity'],
                'unit' => $product ? $product->productUnit->unit : 'ไม่ทราบหน่วย',
                'price' => $product ? $product->price : 0,
                'total_sales' => $sale['quantity'] * ($product ? $product->price : 0),
            ];
        });
    
        // รวบรวมข้อมูลสุดท้ายที่จะแสดงในตารางรายปี
        $finalYearlySalesData = collect($aggregatedYearlySales)->map(function ($sale, $productId) use ($productDetails) {
            $product = $productDetails->get($productId);
            return [
                'product_id' => $productId,
                'product_name' => $product ? $product->product_name : 'ไม่ทราบชื่อสินค้า',
                'quantity' => $sale['quantity'],
                'unit' => $product ? $product->productUnit->unit : 'ไม่ทราบหน่วย',
                'price' => $product ? $product->price : 0,
                'total_sales' => $sale['quantity'] * ($product ? $product->price : 0),
            ];
        });
    
        // ส่งข้อมูลไปยังวิว
        return view('productsalereport.monthlyproductsales', compact('finalMonthlySalesData', 'finalYearlySalesData', 'thaiMonths', 'year', 'month'));
    }     
    
}
