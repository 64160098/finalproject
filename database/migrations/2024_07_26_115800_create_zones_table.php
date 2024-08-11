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
        Schema::create('zones', function (Blueprint $table) {
            $table->id(); // รหัสประจำตัวของโซน
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade'); // รหัสคลังสินค้าที่โซนนี้อยู่
            $table->string('name'); // ชื่อโซน
            $table->decimal('width', 10, 2)->nullable(); // ความกว้างของโซน
            $table->decimal('length', 10, 2)->nullable(); // ความยาวของโซน
            $table->decimal('height', 10, 2)->nullable(); // ความสูงของโซน
            $table->enum('status', ['Active', 'Inactive'])->default('Active'); // สถานะของโซน
            $table->timestamps(); // วันที่สร้างและวันที่อัปเดต
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
