<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    // Create Index
    public function index() {
            // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $zones = Zone::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $zones = Zone::orderBy('id', 'asc')->paginate(5);
        }

        return view('warehouse.zone', ['zones' => $zones]);
    }

    public function create($warehouseId) {
        // ดึงข้อมูลคลังสินค้า
        $warehouse = Warehouse::findOrFail($warehouseId);
    
        // ดึงข้อมูลสินค้าทั้งหมด
        $products = Product::all();
    
        // ส่งข้อมูลคลังสินค้าและสินค้าทั้งหมดไปยัง view
        return view('warehouse.createzone', compact('warehouse', 'products'));
    }

    // Store resource
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'id' => 'required|unique:zones,id',
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required',
            'zone_width' => 'required|numeric',
            'zone_length' => 'required|numeric',
            'zone_height' => 'required|numeric',
            'zone_status' => 'required',
        ]);
    
        // Calculate volume
        $zone_volume = $validated['zone_width'] * $validated['zone_length'] * $validated['zone_height'];
    
        // Create a new zone
        $zone = new Zone;
        $zone->id = $validated['id'];
        $zone->product_id = $validated['product_id'];
        $zone->warehouse_id = $validated['warehouse_id'];
        $zone->name = $validated['name'];
        $zone->zone_width = $validated['zone_width'];
        $zone->zone_length = $validated['zone_length'];
        $zone->zone_height = $validated['zone_height'];
        $zone->zone_volume = $zone_volume;
        $zone->zone_status = $validated['zone_status'];
        $zone->save();
    
        // Redirect with success message
        return redirect()->route('warehouse.zone', ['id' => $validated['warehouse_id']])->with('success', 'เพิ่มข้อมูลโซนเรียบร้อยแล้ว');
    }

    public function edit($zoneId) {
        // ดึงข้อมูลโซนจาก ID ที่ระบุ
        $zone = Zone::find($zoneId);
    
        // ตรวจสอบว่าโซนที่ระบุมีอยู่จริงหรือไม่
        if (!$zone) {
            return redirect()->route('warehouse.warehouses')->with('error', 'Zone not found.');
        }
    
        // ดึงข้อมูลคลังสินค้าที่เกี่ยวข้อง
        $warehouse = $zone->warehouse;
    
        // ดึงข้อมูลสินค้าทั้งหมด
        $products = Product::all();
    
        // ดึงข้อมูลสินค้าที่สัมพันธ์กับ Zone นี้
        $product = $zone->product;
    
        // ส่งข้อมูลไปยัง view
        return view('warehouse.editzone', compact('zone', 'warehouse', 'products', 'product'));
    } 
    
    public function update(Request $request, $id) {
        // Validate the request
        $validated = $request->validate([
            'id' => 'required|unique:zones,id,' . $id, // ต้องไม่ซ้ำยกเว้นกับโซนที่กำลังแก้ไข
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'name' => 'required',
            'zone_width' => 'required|numeric',
            'zone_length' => 'required|numeric',
            'zone_height' => 'required|numeric',
            'zone_status' => 'required',
        ]);
    
        // Calculate volume
        $zone_volume = $validated['zone_width'] * $validated['zone_length'] * $validated['zone_height'];
    
        // Update existing zone
        $zone = Zone::find($id);
        $zone->id = $validated['id'];
        $zone->product_id = $validated['product_id'];
        $zone->warehouse_id = $validated['warehouse_id'];
        $zone->name = $validated['name'];
        $zone->zone_width = $validated['zone_width'];
        $zone->zone_length = $validated['zone_length'];
        $zone->zone_height = $validated['zone_height'];
        $zone->zone_volume = $zone_volume;
        $zone->zone_status = $validated['zone_status'];
        $zone->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'แก้ไขข้อมูลโซนเรียบร้อยแล้ว'], 200);
        }
    
        return redirect()->route('warehouse.zone', ['id' => $validated['warehouse_id']])->with('success', 'แก้ไขข้อมูลโซนเรียบร้อยแล้ว');
    }    
    
    public function destroy($warehouseId, Zone $zone) {
        $zone->delete();
        return response()->json(['success' => 'ข้อมูลสินค้าถูกลบเรียบร้อยแล้ว'], 200);
    }

    public function getProductDetailsByZone($id) {

    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json([
        'product_name' => $product->product_name,
        'product_width' => $product->product_width,
        'product_length' => $product->product_length,
        'product_height' => $product->product_height,
        'product_volume' => $product->product_volume,
    ]);
    }

}
