<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EoqropCalculation;
use Illuminate\Support\Facades\DB;

class EoqropCalculationController extends Controller
{

         // Create Index
         public function index() {
            $ropeoqs = DB::table('eoqrop_calculations')->orderBy('id', 'asc')->paginate(5);
            return view('product.products', ['ropeoqs' => $ropeoqs]);
        }

        // Store resource
        public function store(Request $request)
        {
            // Validate the request
            $validated = $request->validate([
                'id' => 'required|unique:zones,id',
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
            ]);

            // Convert product volume from cm³ to m³
            $product_volume_m3 = $validated['product_volume'] / 1_000_000;
        
            // Calculate EOQ
            $eoq = sqrt((2 * $validated['demand'] * $validated['order_cost']) / $validated['holding_cost']);

            // Calculate ROP
            $rop = $validated['daily_usage_rate'] * $validated['lead_time'];

            // Calculate storageCapacity 
            $storage_capacity  = $validated['zone_volume'] / $product_volume_m3;

        
            // Create a new zone
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
            $eoqrop->eoq = $eoq;
            $eoqrop->rop = $rop;
            $eoqrop->storage_capacity = $storage_capacity;
            $eoqrop->save();
        
            // Redirect with success message
            return redirect()->route('product.products')->with('success', 'วิเคราะห์ข้อมูลเรียบร้อยแล้ว');
        }
}
