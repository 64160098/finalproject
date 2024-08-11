<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductTypeController extends Controller
{
    // Create Index
    public function index() {
            // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $producttypes = ProductType::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $producttypes = ProductType::orderBy('id', 'asc')->paginate(5);
        }

        return view('producttype.producttypes', ['producttypes' => $producttypes]);
    }

    // Create resource
    public function create() {
        return view('producttype.create');
    }

    //Store resource
    public function store(Request $request) {

        $existingProducttype = ProductType::where('id', $request->id)
        ->orWhere('product_type', $request->product_type)
        ->first();
        
        if ($existingProducttype) {
            if ($existingProducttype->id === $request->id) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['id' => ['รหัสประเภทสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['id' => 'รหัสประเภทสินค้านี้ถูกใช้ไปแล้ว']);
            } else {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['product_type' => ['ชื่อประเภทสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['product_type' => 'ชื่อประเภทสินค้านี้ถูกใช้ไปแล้ว']);
            }
        }   

        $validatedData = $request->validate([
            'id' => 'required|unique:product_types,id',
            'product_type' => 'required'
        ]);
    
        $producttype = new ProductType;
        $producttype->id = $validatedData['id'];
        $producttype->product_type = $validatedData['product_type'];
        $producttype->save();

        if ($request->ajax()) {
            return response()->json(['success' => 'เพิ่มข้อมูลประเภทสินค้าเรียบร้อยแล้ว'], 200);
        }

        return redirect()->route('producttype.producttypes')->with('success', 'เพิ่มข้อมูลประเภทสินค้าเรียบร้อยแล้ว');
    }

    public function edit(ProductType $producttype) {
        return view('producttype.edit', compact('producttype'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'id' => 'required|unique:product_types,id,' . $id,
            'product_type' => 'required'
        ]);
    
        // ตรวจสอบว่ามีข้อมูลที่มีรหัสหรือชื่อซ้ำกับข้อมูลที่ไม่ใช่ตัวเองหรือไม่
        $existingProductType = ProductType::where('id', '!=', $id) // ไม่รวมตัวเองที่กำลังอัปเดต
            ->where(function($query) use ($request) {
                $query->where('id', $request->id)
                      ->orWhere('product_type', $request->product_type);
            })
            ->first();
    
        if ($existingProductType) {
            // ตรวจสอบว่ารหัสประเภทสินค้าซ้ำหรือไม่
            if ($existingProductType->id === $request->id) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['id' => ['รหัสประเภทสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['id' => 'รหัสประเภทสินค้านี้ถูกใช้ไปแล้ว']);
            } 
            // ตรวจสอบว่าชื่อประเภทสินค้าซ้ำหรือไม่
            elseif ($existingProductType->product_type === $request->product_type) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['product_type' => ['ชื่อประเภทสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['product_type' => 'ชื่อประเภทสินค้านี้ถูกใช้ไปแล้ว']);
            }
        } 
    
        $producttype = ProductType::findOrFail($id); // ใช้ findOrFail เพื่อหาข้อมูล ถ้าไม่พบจะส่ง HTTP 404 กลับ
        $producttype->id = $request->id;
        $producttype->product_type = $request->product_type;
        $producttype->save();
        
        if ($request->ajax()) {
            return response()->json(['success' => 'แก้ไขข้อมูลประเภทสินค้าเรียบร้อยแล้ว']);
        }
        
        return redirect()->route('producttype.producttypes')->with('status', 'แก้ไขข้อมูลประเภทสินค้าเรียบร้อยแล้ว');
    }
    
    public function destroy(ProductType $producttype) {
        $producttype->delete();
        return response()->json(['success' => 'ลบข้อมูลประเภทสินค้าเรียบร้อยแล้ว'], 200);
    }

}
