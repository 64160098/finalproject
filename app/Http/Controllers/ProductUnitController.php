<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductUnitController extends Controller
{
    // Create Index
    public function index() {
            // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $productunits = ProductUnit::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $productunits = ProductUnit::orderBy('id', 'asc')->paginate(5);
        }

        return view('productunit.productunits', ['productunits' => $productunits]);
    }

    // Create resource
    public function create() {
        return view('productunit.create');
    }

    //Store resource
    public function store(Request $request) {

        $existingProductUnit = ProductUnit::where('unit', $request->unit)->first();
        
        if ($existingProductUnit) {
            if ($existingProductUnit->unit === $request->unit) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['unit' => ['ชื่อหน่วยนับนี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['unit' => 'ชื่อหน่วยนับนี้ถูกใช้ไปแล้ว']);
            }
        }   

       //$existingProductUnit = ProductUnit::where('unit', $request->unit)->first();

       //if ($existingProductUnit) {
       //     return back()->withErrors(['unit' => 'ชื่อหน่วยนับนี้ถูกใช้ไปแล้ว']);
       //}

        $request->validate([
            'id' => 'required|unique:product_units,id',
            'unit' => 'required',
        ]);

        $productunit = new ProductUnit;
        $productunit->id = $request->id;
        $productunit->unit = $request->unit;
        $productunit->save();
        return redirect()->route('productunit.productunits')->with('success', 'เพิ่มข้อมูลหน่วยนับเรียบร้อยแล้ว');
    }

    public function edit(ProductUnit $productunit) {
        return view('productunit.edit', compact('productunit'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'id' => 'required|unique:product_units,id,' . $id,
            'unit' => 'required',
        ]);

        
                // ตรวจสอบว่ามีข้อมูลที่มีรหัสหรือชื่อซ้ำกับข้อมูลที่ไม่ใช่ตัวเองหรือไม่
                $existingProductUnit = ProductUnit::where('id', '!=', $id) // ไม่รวมตัวเองที่กำลังอัปเดต
                ->where(function($query) use ($request) {
                    $query->where('unit', $request->unit);
                })
                ->first();
        
            if ($existingProductUnit) {
                // ตรวจสอบว่ารหัสประเภทสินค้าซ้ำหรือไม่
                if ($existingProductUnit->unit === $request->unit) {
                    if ($request->ajax()) {
                        return response()->json(['errors' => ['unit' => ['ชื่อหน่วยนับนี้ถูกใช้ไปแล้ว']]], 422);
                    }
                    return back()->withErrors(['unit' => 'ชื่อหน่วยนับนี้ถูกใช้ไปแล้ว']);
                } 
            } 

        $productunit = ProductUnit::find($id);
        $productunit->id = $request->id;
        $productunit->unit = $request->unit;
        $productunit->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'แก้ไขข้อมูลหน่วยนับเรียบร้อยแล้ว']);
        }

        return redirect()->route('productunit.productunits')->with('status', 'แก้ไขข้อมูลหน่วยนับเรียบร้อยแล้ว');
    }

    public function destroy(ProductUnit $productunit) {
        $productunit->delete();
        return response()->json(['success' => 'ลบข้อมูลหน่วยนับเรียบร้อยแล้ว'], 200);
    }

}
