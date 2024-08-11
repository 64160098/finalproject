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
        Schema::create('wearhouses', function (Blueprint $table) {
            $table->id(); // รหัสประจำตัวของคลังสินค้า
            $table->string('name'); // ชื่อคลังสินค้า
            $table->text('address')->nullable(); // ที่อยู่ของคลังสินค้า
            $table->decimal('total_area', 10, 2); // พื้นที่ทั้งหมด
            $table->decimal('available_area', 10, 2); // พื้นที่จัดเก็บที่ใช้ได้
            $table->decimal('width', 10, 2)->nullable(); // ความกว้าง
            $table->decimal('length', 10, 2)->nullable(); // ความยาว
            $table->decimal('height', 10, 2)->nullable(); // ความสูง
            $table->string('area_type')->nullable(); // ประเภทพื้นที่
            $table->enum('status', ['Active', 'Inactive', 'Under Maintenance'])->default('Active'); // สถานะ
            $table->timestamps(); // วันที่สร้างและวันที่อัปเดต
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wearhouses');
    }
};
