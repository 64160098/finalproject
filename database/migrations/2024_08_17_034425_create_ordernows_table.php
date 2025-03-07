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
        Schema::create('ordernows', function (Blueprint $table) {
            $table->id(); // เลขที่ใบสั่งซื้อและ primary key
            $table->date('order_date'); // วันที่สั่งซื้อ
            $table->unsignedBigInteger('supplier_id'); // รหัสผู้ขาย
            $table->json('products'); // คอลัมน์ JSON สำหรับเก็บข้อมูลสินค้าหลายรายการ (product_id, quantity)
            $table->unsignedBigInteger('employee_id'); // รหัสผู้สั่งซื้อ
            $table->timestamps();
            
            // Adding foreign key constraints
            $table->foreign('supplier_id')->references('id')->on('supplier_information')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employee_information')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordernows');
    }
};
