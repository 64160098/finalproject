<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrderList;
use App\Models\Product;
use App\Models\OrderProducts;
use App\Models\Warehouse;
use App\Models\Inventory;
use App\Models\EoqropCalculation;

class OrderListController extends Controller
{
    public function index() {
        // ดึงคำค้นหาจาก request
        $searchTerm = request('search');
        
        // ตรวจสอบว่ามีคำค้นหาหรือไม่
        if ($searchTerm) {
            // ใช้ Scout ในการค้นหา
            $orderlists = OrderList::search($searchTerm)->paginate(5);
        } else {
            // ดึงสินค้าที่ควรสั่งซื้อใหม่
            $orderlists = $this->getProductsToReorder();
        }

        return view('orderlist.orderlists', ['orderlists' => $orderlists]);
    }

    private function getProductsToReorder() {
        // Join ตาราง inventories, eoqrop_calculations, zones และ warehouses เพื่อตรวจสอบสินค้าที่ควรสั่งซื้อใหม่
        $productsToReorder = Inventory::join('eoqrop_calculations', 'inventories.product_id', '=', 'eoqrop_calculations.product_id')
            ->join('products', 'inventories.product_id', '=', 'products.id') // Join ตาราง products เพื่อดึงชื่อสินค้า
            ->join('zones', 'eoqrop_calculations.zone_id', '=', 'zones.id') // Join ตาราง zones เพื่อดึงข้อมูลโซน
            ->join('warehouses', 'zones.warehouse_id', '=', 'warehouses.id') // Join ตาราง warehouses เพื่อดึงชื่อคลังสินค้า
            ->select(
                'inventories.product_id',
                'products.product_name as product_name',
                'inventories.amount',
                'eoqrop_calculations.rop',
                'warehouses.name as warehouse_name' // ดึงชื่อคลังสินค้า
            )
            ->whereRaw('inventories.amount <= eoqrop_calculations.rop') // เงื่อนไขในการตรวจสอบสินค้าที่ต้องสั่งซื้อใหม่
            ->orderBy('inventories.product_id', 'asc') // จัดเรียงข้อมูลตาม product_id
            ->paginate(5); // แบ่งหน้าข้อมูล
    
        return $productsToReorder;
    }
    

}
