<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use App\Models\Product;

class InventoryController extends Controller
{
    // Create Index
    public function index() {
        $inventories = DB::table('inventories')->orderBy('id', 'asc')->paginate(5);
        return view('inventory.inventories', ['inventories' => $inventories]);
    }

    // Create resource
    public function create() {
        return view('inventory.create');
    }

    public function edit(Inventory $inventory) {
        return view('inventory.edit', compact('inventory'));
    }
    
    public function update(Request $request, Inventory $inventory) {
        $request->validate([
            'amount' => 'required|numeric',
        ]);
    
        $inventory->amount = $request->amount;
        $inventory->save();
    
        return redirect()->route('inventory.inventories')->with('success', 'Inventory updated successfully');
    }
    
    public function showInventoryForm() {
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
        
        // ดึงข้อมูลสินค้าพร้อมกับข้อมูลสินค้าในคลัง
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $products = Product::search($searchTerm)->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลสินค้าทั้งหมด
            $products = Product::with('inventory')->paginate(5);
        }
    
        // ดึงข้อมูลสินค้าในคลังทั้งหมดแบบ paginate
        $inventories = DB::table('inventories')->orderBy('id', 'asc')->paginate(5);
    
        return view('inventory.inventories', compact('products', 'inventories'));
    }
    

}
