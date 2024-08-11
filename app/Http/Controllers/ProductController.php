<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductType;
use App\Models\ProductUnit;
use App\Models\Warehouse;
use App\Models\Zone;

class ProductController extends Controller
{
    public function index()
    {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
    
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $products = Product::search($searchTerm)
                ->with('productType', 'productUnit') // โหลดข้อมูลที่เกี่ยวข้อง
                ->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $products = Product::orderBy('id', 'asc')
                ->with('productType', 'productUnit') // โหลดข้อมูลที่เกี่ยวข้อง
                ->paginate(5);
        }
    
        return view('product.products', ['products' => $products]);
    }
    

    public function count()
    {
        // นับจำนวนสินค้าทั้งหมด
        $productCount = Product::count();

        // ส่งจำนวนสินค้าไปยัง view
        return view('admin', compact('productCount'));
    }

    // Create resource
    public function create() {
        $producttypes = ProductType::all();
        $units = ProductUnit::all();
        return view('product.create', [
        'producttypes' => $producttypes,
        'units' => $units
    ]);
    }

    public function store(Request $request) {
        $request->validate([
            'id' => 'required',
            'product_name' => 'required',
            'product_type_id' => 'required|exists:product_types,id',
            'product_unit_id' => 'required|exists:product_units,id',
            'product_width' => 'required|numeric',
            'product_length' => 'required|numeric',
            'product_height' => 'required|numeric',
            'price' => 'required'
        ]);
    
        // Calculate volume
        $product_volume = $request->product_width * $request->product_length * $request->product_height;
    
        $existingProduct = Product::where('id', $request->id)
            ->orWhere('product_name', $request->product_name)
            ->first();
        
        if ($existingProduct) {
            if ($existingProduct->id === $request->id) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['id' => ['รหัสสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['id' => 'รหัสสินค้านี้ถูกใช้ไปแล้ว']);
            } else {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['product_name' => ['ชื่อสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['product_name' => 'ชื่อสินค้านี้ถูกใช้ไปแล้ว']);
            }
        }  
    
        $product = new Product;
        $product->id = $request->id;
        $product->product_name = $request->product_name;
        $product->product_type_id = $request->product_type_id; // แก้ไขตรงนี้
        $product->product_unit_id = $request->product_unit_id; // แก้ไขตรงนี้
        $product->product_width = $request->product_width;
        $product->product_length = $request->product_length;
        $product->product_height = $request->product_height;
        $product->product_volume = $product_volume;
        $product->price = $request->price;
        $product->save();
    
        return redirect()->route('product.products')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
    }
    

    public function edit(Product $product) {
        $producttypes = ProductType::all();
        $units = ProductUnit::all();
        return view('product.edit', compact('product', 'producttypes', 'units'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'id' => 'required',
            'product_name' => 'required',
            'product_type_id' => 'required|exists:product_types,id',
            'product_unit_id' => 'required|exists:product_units,id',
            'product_width' => 'required|numeric',
            'product_length' => 'required|numeric',
            'product_height' => 'required|numeric',
            'price' => 'required',
        ]);
    
        // Calculate volume
        $product_volume = $request->product_width * $request->product_length * $request->product_height;
    
        // ตรวจสอบว่ามีข้อมูลที่มีรหัสหรือชื่อซ้ำกับข้อมูลที่ไม่ใช่ตัวเองหรือไม่
        $existingProduct = Product::where('id', '!=', $id) // ไม่รวมตัวเองที่กำลังอัปเดต
            ->where(function($query) use ($request) {
                $query->where('id', $request->id)
                      ->orWhere('product_name', $request->product_name);
            })
            ->first();
        
        if ($existingProduct) {
            // ตรวจสอบว่ารหัสประเภทสินค้าซ้ำหรือไม่
            if ($existingProduct->id === $request->id) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['id' => ['รหัสสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['id' => 'รหัสสินค้านี้ถูกใช้ไปแล้ว']);
            } 
            // ตรวจสอบว่าชื่อประเภทสินค้าซ้ำหรือไม่
            elseif ($existingProduct->product_name === $request->product_name) {
                if ($request->ajax()) {
                    return response()->json(['errors' => ['product_name' => ['ชื่อสินค้านี้ถูกใช้ไปแล้ว']]], 422);
                }
                return back()->withErrors(['product_name' => 'ชื่อสินค้านี้ถูกใช้ไปแล้ว']);
            }
        } 
    
        $product = Product::find($id);
        $product->id = $request->id;
        $product->product_name = $request->product_name;
        $product->product_type_id = $request->product_type_id; // แก้ไขตรงนี้
        $product->product_unit_id = $request->product_unit_id; // แก้ไขตรงนี้
        $product->product_width = $request->product_width;
        $product->product_length = $request->product_length;
        $product->product_height = $request->product_height;
        $product->product_volume = $product_volume;
        $product->price = $request->price;
        $product->save();
        
        return redirect()->route('product.products')->with('success', 'แก้ไขข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->json(['success' => 'ข้อมูลสินค้าถูกลบเรียบร้อยแล้ว'], 200);
    }

    public function createEoq()
    {
        $products = Product::all(); // ดึงข้อมูลสินค้าทั้งหมดจากฐานข้อมูล
        $warehouses = Warehouse::all(); // ดึงข้อมูลสินค้าทั้งหมดจากฐานข้อมูล
        return view('product.createeoq', compact('products', 'warehouses'));
    }

    public function getProductDetails($id)
    {
        // ดึงข้อมูลสินค้าตาม ID
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // ดึงข้อมูลโซนที่สินค้านั้นถูกเก็บอยู่
        $zone = Zone::where('product_id', $id)->with('warehouse')->first();
    
        if (!$zone) {
            return response()->json(['message' => 'Zone not found'], 404);
        }
    
        return response()->json([
            'product' => [
                'name' => $product->product_name,
                'width' => $product->product_width,
                'length' => $product->product_length,
                'height' => $product->product_height,
                'volume' => $product->product_volume,
            ],
            'zone' => [
                'zone_id' => $zone->id,
                'name' => $zone->name,
                'width' => $zone->zone_width,
                'length' => $zone->zone_length,
                'height' => $zone->zone_height,
                'volume' => $zone->zone_volume,
            ],
            'warehouse' => [
                'warehouse_id' => $zone->warehouse->id,
                'name' => $zone->warehouse->name,
                'total_area' => $zone->warehouse->warehouse_total_area,
                'available_area' => $zone->warehouse->warehouse_available_area,
                'width' => $zone->warehouse->warehouse_width,
                'length' => $zone->warehouse->warehouse_length,
                'height' => $zone->warehouse->warehouse_height,
            ]
        ]);
    }
    
    // Create resource
    public function seemore() {
        return view('product.detail');
    }

    // Create resource
    public function seemorerop() {
        return view('product.detailrop');
    }

}
