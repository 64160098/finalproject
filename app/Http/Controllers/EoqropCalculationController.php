<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EoqropCalculation;
use App\Models\Product;
use App\Models\Zone;
use App\Models\Warehouse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class EoqropCalculationController extends Controller
{

         // Create Index
         public function index() {
            $eoqrops = DB::table('eoqrop_calculations')->orderBy('id', 'asc')->paginate(5);
            return view('product.detailmore', ['eoqrops' => $eoqrops]);
        }

    // Store resource
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'id' => 'required|unique:eoqrop_calculations,id',
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'zone_id' => 'required|exists:zones,id',
            'product_volume' => 'required|numeric',
            'zone_volume' => 'required|numeric',
            'demand' => 'required|numeric',
            'order_cost' => 'required|numeric',
            'holding_cost' => 'required|numeric',
            'daily_usage_rate' => 'required',
            'lead_time' => 'required',
            'safety_stock' => 'required',
        ]);

        // ตรวจสอบว่าสินค้าตัวนี้มีอยู่แล้วหรือไม่ใน eoqrop_calculations
        $existingEoqrop = EoqropCalculation::where('product_id', $validated['product_id'])
                                        ->where('warehouse_id', $validated['warehouse_id'])
                                        ->where('zone_id', $validated['zone_id'])
                                        ->first();

        if ($existingEoqrop) {
            // ถ้ามีข้อมูลสินค้าซ้ำกัน ส่งข้อความแจ้งเตือนกลับไป
            return response()->json(['message' => 'สินค้านี้ถูกวิเคราะห์ในคลังสินค้านี้แล้ว ไม่สามารถเพิ่มซ้ำได้'], 400);
        }

        // Convert product volume from cm³ to m³
        $product_volume_m3 = $validated['product_volume'] / 1_000_000;

        // Calculate EOQ
        $eoq = sqrt((2 * $validated['demand'] * $validated['order_cost']) / $validated['holding_cost']);

        // Calculate ROP
        $rop = $validated['daily_usage_rate'] * $validated['lead_time'] + $validated['safety_stock'];

        // Calculate storageCapacity
        $storage_capacity = $validated['zone_volume'] / $product_volume_m3;

        // Create a new eoqrop
        $eoqrop = new EoqropCalculation;
        $eoqrop->id = $validated['id'];
        $eoqrop->product_id = $validated['product_id'];
        $eoqrop->warehouse_id = $validated['warehouse_id'];
        $eoqrop->zone_id = $validated['zone_id'];
        $eoqrop->demand = $validated['demand'];
        $eoqrop->order_cost = $validated['order_cost'];
        $eoqrop->holding_cost = $validated['holding_cost'];
        $eoqrop->daily_usage_rate = $validated['daily_usage_rate'];
        $eoqrop->lead_time = $validated['lead_time'];
        $eoqrop->safety_stock = $validated['safety_stock'];
        $eoqrop->eoq = $eoq;
        $eoqrop->rop = $rop;
        $eoqrop->storage_capacity = $storage_capacity;
        $eoqrop->save();

        // ส่งข้อความสำเร็จในรูปแบบ JSON
        return response()->json(['message' => 'เพิ่มข้อมูลวิเคราะห์สินค้าเรียบร้อยแล้ว'], 200);
    }      

        public function update(Request $request, $id)
        {
            // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
            $validated = $request->validate([
                'id' => 'required|integer',
                'product_id' => 'required|exists:products,id',
                'warehouse_id' => 'required|exists:warehouses,id',
                'zone_id' => 'required|exists:zones,id',
                'product_volume' => 'required|numeric',
                'zone_volume' => 'required|numeric',
                'demand' => 'required|numeric',
                'order_cost' => 'required|numeric',
                'holding_cost' => 'required|numeric',
                'daily_usage_rate' => 'required|numeric',
                'lead_time' => 'required|numeric',
                'safety_stock' => 'required|numeric',
            ]);
        
            // ตรวจสอบว่า `id` ใหม่มีอยู่ในฐานข้อมูลหรือไม่
            if (EoqropCalculation::where('id', $validated['id'])->where('id', '<>', $id)->exists()) {
                return redirect()->route('product.products')->with('error', 'รหัสใหม่มีอยู่แล้วในระบบ');
            }
        
            // แปลงปริมาตรผลิตภัณฑ์จาก cm³ เป็น m³
            $product_volume_m3 = $validated['product_volume'] / 1_000_000;
        
            // คำนวณ EOQ
            $eoq = sqrt((2 * $validated['demand'] * $validated['order_cost']) / $validated['holding_cost']);
        
            // คำนวณ ROP
            $rop = $validated['daily_usage_rate'] * $validated['lead_time'] + $validated['safety_stock'];
        
            // คำนวณความจุการจัดเก็บ
            $storage_capacity = $validated['zone_volume'] / $product_volume_m3;
        
            // ค้นหาเรคคอร์ดที่มีอยู่ตาม $id
            $eoqrop = EoqropCalculation::find($id);
            if ($eoqrop) {
                // อัปเดตข้อมูล
                $eoqrop->id = $validated['id'];
                $eoqrop->product_id = $validated['product_id'];
                $eoqrop->warehouse_id = $validated['warehouse_id'];
                $eoqrop->zone_id = $validated['zone_id'];
                $eoqrop->demand = $validated['demand'];
                $eoqrop->order_cost = $validated['order_cost'];
                $eoqrop->holding_cost = $validated['holding_cost'];
                $eoqrop->daily_usage_rate = $validated['daily_usage_rate'];
                $eoqrop->lead_time = $validated['lead_time'];
                $eoqrop->safety_stock = $validated['safety_stock'];
                $eoqrop->eoq = $eoq;
                $eoqrop->rop = $rop;
                $eoqrop->storage_capacity = $storage_capacity;
                $eoqrop->save();
        
                // เปลี่ยนเส้นทางและแสดงข้อความสำเร็จ
                return redirect()->route('product.detailmore', $validated['product_id'])
                ->with('success', 'อัพเดทข้อมูลเรียบร้อยแล้ว');
                } else {
                return redirect()->route('product.detailmore', $validated['product_id'])->with('error', 'ไม่พบข้อมูลที่ต้องการอัพเดท');
                }
        }        

        public function generatePDF($id) {
            $eoqrop = EoqropCalculation::find($id);
        
            if (!$eoqrop) {
                abort(404, 'ข้อมูลไม่พบ');
            }

            $product = Product::find($eoqrop->product_id);
            $warehouse = Warehouse::find($eoqrop->warehouse_id);
            $zone = Zone::find($eoqrop->zone_id);
        
            $data = [
                'title' => 'รายละเอียดการสั่งซื้อและจุดสั่งซ้ำ',
                'eoqrop' => $eoqrop,
                'product' => $product,
                'warehouse' => $warehouse,
                'zone' => $zone,
            ];
        
            // ตั้งค่าฟอนต์
            Pdf::setOptions([
                'font_dir' => public_path('fonts'),
                'font_cache' => storage_path('fonts'),
                'default_font' => 'THSarabun', // ใช้ชื่อฟอนต์ที่ถูกต้อง
            ]);
        
            // สร้าง PDF
            $pdf = Pdf::loadView('product.eoqropdetail', $data);
            return $pdf->stream('รายละเอียดการสั่งซื้อและจุดสั่งซ้ำ.pdf');
        }

        public function edit($productId) {
            // ดึงข้อมูลสินค้าตาม ID
            $product = Product::find($productId);
        
            // ตรวจสอบว่าสินค้ามีอยู่หรือไม่
            if (!$product) {
                return redirect()->route('product.products')->with('error', 'Product not found.');
            }
        
            // ดึงข้อมูล EOQROP Calculation ที่เกี่ยวข้องกับสินค้านี้
            $eoqrop = EoqropCalculation::where('product_id', $productId)->first();
        
            // ตรวจสอบว่าเจอข้อมูล EOQROP Calculation หรือไม่
            if (!$eoqrop) {
                return redirect()->route('product.products')->with('error', 'EOQROP Calculation not found.');
            }
        
            // ดึงข้อมูล Warehouse และ Zone ที่เกี่ยวข้องตาม ID ที่ได้จาก EOQROP Calculation
            $warehouse = Warehouse::find($eoqrop->warehouse_id);
            $zone = Zone::find($eoqrop->zone_id);
        
            // ดึงรายการสินค้าทั้งหมด
            $products = Product::all(); // หรือวิธีที่คุณใช้ในการดึงรายการสินค้าทั้งหมด
        
            // ส่งข้อมูลไปยัง view
            return view('product.editeoq', compact('product', 'eoqrop', 'products', 'warehouse', 'zone'));
        }

        public function destroy(EoqropCalculation $eoqrop) {
            $eoqrop->delete();
            return response()->json(['success' => 'ข้อมูล EOQ และ ROP ของสินค้าถูกลบเรียบร้อยแล้ว'], 200);
        }          
        
        public function showDetails(Request $request, $productId) 
        {
            // ดึงข้อมูลสินค้าโดยใช้ ID
            $product = Product::find($productId);
            
            // ดึงข้อมูล EOQROP Calculation ที่เกี่ยวข้องกับสินค้า
            $eoqrops = EoqropCalculation::where('product_id', $productId)->get();
            
            // ดึงข้อมูล EOQROP ที่ต้องการแสดง (เอาข้อมูลตัวแรก)
            $eoqrop = $eoqrops->first(); // ถ้าคุณต้องการแค่ตัวแรก
            
            // ดึงข้อมูล Warehouse ที่เกี่ยวข้องกับ EOQROP Calculation
            $warehouse = Warehouse::find($eoqrop->warehouse_id);
            
            // ดึงข้อมูล Zone ที่เกี่ยวข้องกับ EOQROP Calculation
            $zone = Zone::find($eoqrop->zone_id);
            
            // ส่งข้อมูลไปยัง view พร้อมข้อมูลที่จำเป็น
            return view('product.detailmore', compact('product', 'eoqrop', 'warehouse', 'zone'));
        }                               
         
        public function getProductAndWarehouses($productId)
        {
            // ดึงข้อมูลสินค้าตาม ID
            $product = Product::find($productId);
        
            if (!$product) {
                return response()->json(['message' => 'Product not found'], 404);
            }
        
            // ดึงข้อมูลคลังสินค้าที่เกี่ยวข้องกับสินค้า
            $warehouses = Warehouse::whereHas('zones', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })->get();
        
            if ($warehouses->isEmpty()) {
                return response()->json(['message' => 'No warehouses found for this product'], 404);
            }
        
            return response()->json([
                'product' => [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'width' => $product->product_width,
                    'length' => $product->product_length,
                    'height' => $product->product_height,
                    'volume' => $product->product_volume
                ],
                'warehouses' => $warehouses->map(function ($warehouse) {
                    return [
                        'warehouse_id' => $warehouse->id,
                        'name' => $warehouse->name
                    ];
                }),
            ]);
        }
        
        public function getZonesByWarehouse($warehouseId, $productId)
        {
            // ดึงข้อมูลโซนที่คลังสินค้านั้นเก็บสินค้าตาม Product ID
            $zones = Zone::where('warehouse_id', $warehouseId)
                         ->where('product_id', $productId)
                         ->get();
        
            if ($zones->isEmpty()) {
                return response()->json(['message' => 'No zones found for this warehouse and product'], 404);
            }
        
            // ดึงข้อมูลคลังสินค้า
            $warehouse = Warehouse::find($warehouseId);
        
            if (!$warehouse) {
                return response()->json(['message' => 'Warehouse not found'], 404);
            }
        
            return response()->json([
                'warehouses' => [
                    [
                        'name' => $warehouse->name,
                        'width' => $warehouse->warehouse_width,
                        'length' => $warehouse->warehouse_length,
                        'height' => $warehouse->warehouse_height,
                        'total_area' => $warehouse->warehouse_total_area,
                        'available_area' => $warehouse->warehouse_available_area
                    ]
                ],
                'zones' => $zones->map(function ($zone) {
                    return [
                        'zone_id' => $zone->id,
                        'name' => $zone->name,
                        'width' => $zone->zone_width,
                        'length' => $zone->zone_length,
                        'height' => $zone->zone_height,
                        'volume' => $zone->zone_volume
                    ];
                }),
            ]);
        } 
        
        public function getZoneDetails($zoneId) {
            $zone = Zone::find($zoneId);
            if (!$zone) {
                return response()->json(['message' => 'Zone not found'], 404);
            }
        
            return response()->json([
                'zone' => [
                    'id' => $zone->id,
                    'name' => $zone->name,
                    'width' => $zone->zone_width,
                    'length' => $zone->zone_length,
                    'height' => $zone->zone_height,
                    'volume' => $zone->zone_volume  // ปริมาตรถูกคืนค่าอยู่แล้ว
                ]
            ]);
        }
             
}
