<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eoqrop_calculations', function (Blueprint $table) {
            $table->id();
        
            // ข้อมูลสินค้า
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
        
            // ขนาดพื้นจัดเก็บ
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
        
            // ข้อมูลโซน
            $table->foreignId('zone_id')->constrained()->onDelete('cascade');
        
            // ข้อมูลการคำนวณ
            $table->decimal('demand', 10, 2);
            $table->decimal('order_cost', 10, 2);
            $table->decimal('holding_cost', 10, 2);
            $table->decimal('daily_usage_rate', 10, 2);
            $table->decimal('lead_time', 10, 2);
        
            // ค่า EOQ และ ROP
            $table->decimal('eoq', 10, 2);
            $table->decimal('rop', 10, 2);

            // จำนวนชิ้นที่สามารถจัดเก็บได้
            $table->decimal('storage_capacity', 10, 2);
        
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eoqrop_calculations');
    }
};
