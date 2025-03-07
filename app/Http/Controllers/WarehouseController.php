<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    // Create Index
    public function index() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');

        // ดึงข้อมูลคลังสินค้าพร้อมกับโซน
        $warehouses = Warehouse::with('zones')->get();

        // ตรวจสอบว่ามีคลังสินค้าหรือไม่
        if ($warehouses->isEmpty()) {
            // แสดงข้อความแจ้งเตือนใน view
            return view('warehouse.warehouses', [
                'warehouse' => null,
                'zones' => [],
                'totalUsedArea' => 0,
                'availableArea' => 0,
                'error' => 'ยังไม่มีข้อมูลคลังสินค้า กรุณาเพิ่มข้อมูลคลังสินค้า'
            ]);
        }

        // ใช้คลังสินค้าตัวแรกในการทำงานต่อไป
        $warehouse = $warehouses->first();

        // คำนวณพื้นที่ทั้งหมดของคลังสินค้า
        $totalUsedArea = 0;
        foreach ($warehouse->zones as $zone) {
            $zoneArea = $zone->zone_width * $zone->zone_length;
            $totalUsedArea += $zoneArea;
        }

        // พื้นที่ที่เหลืออยู่ในคลังสินค้า
        $availableArea = $warehouse->warehouse_available_area - $totalUsedArea;

        // ตรวจสอบว่ามีคำค้นหาโซนหรือไม่
        if ($searchTerm) {
            // ค้นหาโซนตามคำค้นหา
            $zones = Zone::where('id', 'like', "%{$searchTerm}%")
                ->orWhere('product_id', 'like', "%{$searchTerm}%")
                ->orWhere('name', 'like', "%{$searchTerm}%")
                ->orWhere('zone_width', 'like', "%{$searchTerm}%")
                ->orWhere('zone_length', 'like', "%{$searchTerm}%")
                ->orWhere('zone_height', 'like', "%{$searchTerm}%")
                ->orWhere('zone_volume', 'like', "%{$searchTerm}%")
                ->orWhere('zone_status', 'like', "%{$searchTerm}%")
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $zones = Zone::orderBy('id', 'asc')
                ->paginate(5);
        }

        // ส่งข้อมูลไปยัง view โดยใช้ totalUsedArea และ availableArea ที่คำนวณจากโซนทั้งหมด
        return view('warehouse.warehouses', compact('warehouse', 'zones', 'totalUsedArea', 'availableArea'));
    } 

    // Create resource
    public function create() {
        // ตรวจสอบว่ามีคลังสินค้าอยู่แล้วหรือไม่
        $warehouses = Warehouse::all();

        if ($warehouses->isNotEmpty()) {
            // ถ้ามีข้อมูลคลังสินค้าแล้ว ให้เด้งกลับไปที่หน้า warehouse.warehouses พร้อมกับข้อความแจ้งเตือน
            return redirect()->route('warehouse.warehouses')->with('error', 'ไม่สามารถสร้างข้อมูลคลังสินค้าได้อีก เนื่องจากมีข้อมูลอยู่แล้ว');
        }

        return view('warehouse.create');
    }

    // Store resource
    public function store(Request $request) {
        $existingWarehouse = Warehouse::where('id', $request->id)->first();
        
        if ($existingWarehouse) {
            if ($existingWarehouse->id === $request->id) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['id' => ['รหัสคลังสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['id' => 'รหัสคลังสินค้านี้ถูกใช้ไปแล้ว']);
            }
        }   

        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'address' => 'required',
            'warehouse_total_area' => 'required',
            'warehouse_available_area' => 'required',
            'warehouse_width' => 'required',
            'warehouse_length' => 'required',
            'warehouse_height' => 'required',
            'warehouse_area_type' => 'required',
            'status' => 'required',
        ]);

        $warehouse = new Warehouse;
        $warehouse->id = $request->id;
        $warehouse->name = $request->name;
        $warehouse->address = $request->address;
        $warehouse->warehouse_total_area = $request->warehouse_total_area;
        $warehouse->warehouse_available_area = $request->warehouse_available_area;
        $warehouse->warehouse_width = $request->warehouse_width;
        $warehouse->warehouse_length = $request->warehouse_length;
        $warehouse->warehouse_height = $request->warehouse_height;
        $warehouse->warehouse_area_type = $request->warehouse_area_type;
        $warehouse->status = $request->status;
        $warehouse->save();
        return redirect()->route('warehouse.warehouses')->with('success', 'เพิ่มข้อมูลหน่วยนับเรียบร้อยแล้ว');
    }

    public function edit(Warehouse $warehouse) {
        return view('warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request, $id) {
        // Validate the request
        $validated = $request->validate([
            'id' => 'required|unique:warehouses,id,' . $id, // ต้องไม่ซ้ำยกเว้นกับคลังสินค้าที่กำลังแก้ไข
            'name' => 'required',
            'address' => 'required',
            'warehouse_total_area' => 'required',
            'warehouse_available_area' => 'required',
            'warehouse_width' => 'required',
            'warehouse_length' => 'required',
            'warehouse_height' => 'required',
            'warehouse_area_type' => 'required',
            'status' => 'required',
        ]);
    
        // Update existing warehouse
        $warehouse = Warehouse::find($id);
        $warehouse->id = $validated['id'];
        $warehouse->name = $validated['name'];
        $warehouse->address = $validated['address'];
        $warehouse->warehouse_total_area = $validated['warehouse_total_area'];
        $warehouse->warehouse_available_area = $validated['warehouse_available_area'];
        $warehouse->warehouse_width = $validated['warehouse_width'];
        $warehouse->warehouse_length = $validated['warehouse_length'];
        $warehouse->warehouse_height = $validated['warehouse_height'];
        $warehouse->warehouse_area_type = $validated['warehouse_area_type'];
        $warehouse->status = $validated['status'];
        $warehouse->save();
    
        if ($request->ajax()) {
            return response()->json(['success' => 'แก้ไขข้อมูลคลังสินค้าสำเร็จ'], 200);
        }
    
        return redirect()->route('warehouse.warehouses')->with('success', 'แก้ไขข้อมูลคลังสินค้าสำเร็จ');
    }

    public function destroy(Warehouse $warehouse) {
        $warehouse->delete();
        return response()->json(['success' => 'ลบข้อมูลคลังสินค้าเรียบร้อยแล้ว'], 200);
    }

    public function show($id)
    {
        // ดึงข้อมูลคลังสินค้าพร้อมกับโซนทั้งหมด
        $warehouse = Warehouse::with('zones')->find($id);
    
        // ตรวจสอบว่ามีคลังสินค้าที่ตรงกับ ID หรือไม่
        if (!$warehouse) {
            return redirect()->route('warehouse.warehouses')->with('error', 'Warehouse not found.');
        }
    
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        // ดึงข้อมูลโซนของคลังสินค้าที่ระบุ
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $zones = Zone::search($searchTerm)->get();
        } else {
            $zones = $warehouse->zones()->get();
        }
    
        // คำนวณพื้นที่ที่ใช้ไปของแต่ละโซน (ตารางเมตร)
        $totalUsedArea = 0;
        foreach ($zones as $zone) {
            $zoneArea = $zone->zone_width * $zone->zone_length;
            $totalUsedArea += $zoneArea;
        }
    
        // พื้นที่จัดเก็บทั้งหมดของคลังสินค้า (ตารางเมตร)
        $warehouseTotalArea = $warehouse->warehouse_available_area;
    
        // คำนวณพื้นที่ที่เหลืออยู่ในคลังสินค้า
        $availableArea = $warehouseTotalArea - $totalUsedArea;
    
        // ส่งข้อมูลไปยัง view
        return view('warehouse.zone', compact('warehouse', 'zones', 'totalUsedArea', 'availableArea'));
    }
    

}
