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
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        $searchTerm = request('search');
        
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา inventory ตามคำค้นหา
            $inventories = Inventory::with(['product.productType', 'product.productUnit'])->where(function ($query) use ($searchTerm) {
                // ค้นหาจากตาราง inventories ฟิลด์ amount
                $query->where('amount', 'like', "%{$searchTerm}%")
                      // ค้นหาจากตาราง products
                      ->orWhereHas('product', function ($query) use ($searchTerm) {
                          $query->where('product_id', 'like', "%{$searchTerm}%")
                                ->orWhere('product_name', 'like', "%{$searchTerm}%")
                                ->orWhere('product_width', 'like', "%{$searchTerm}%")
                                ->orWhere('product_length', 'like', "%{$searchTerm}%")
                                ->orWhere('product_height', 'like', "%{$searchTerm}%")
                                ->orWhere('price', 'like', "%{$searchTerm}%")
                                ->orWhereHas('productType', function($query) use ($searchTerm) {
                                    $query->where('product_type', 'like', "%{$searchTerm}%");
                                })
                                ->orWhereHas('productUnit', function($query) use ($searchTerm) {
                                    $query->where('unit', 'like', "%{$searchTerm}%");
                                });
                      });
            })->paginate(5);
        } else {
            // ถ้าไม่มีคำค้นหา ให้ดึงข้อมูลทั้งหมดแบบปกติ
            $inventories = Inventory::with('product')->paginate(5);
        }

        return view('inventory.inventories', compact('inventories'));
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

}
