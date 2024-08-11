<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    // Create Index
    public function index() {
            // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $warehouses = Warehouse::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $warehouses = Warehouse::orderBy('id', 'asc')->paginate(5);
        }

        return view('warehouse.warehouses', ['warehouses' => $warehouses]);
    }

    // Create resource
    public function create() {
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

    // Show warehouse with zones
    public function show($id) {
        // ดึงข้อมูลคลังสินค้าพร้อมกับโซนทั้งหมด
        $warehouse = Warehouse::with('zones')->find($id);

        // ตรวจสอบว่ามีคลังสินค้าที่ตรงกับ ID หรือไม่
        if (!$warehouse) {
            return redirect()->route('warehouse.warehouses')->with('error', 'Warehouse not found.');
        }

        // ดึงข้อมูลโซนของคลังสินค้าที่ระบุ
        $zones = $warehouse->zones;

        // ส่งข้อมูลไปยัง view
        return view('warehouse.zone', compact('warehouse', 'zones'));
    }
}
