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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('product_name');
            $table->string('product_type');
            $table->string('unit');
            $table->string('color');
            $table->string('size', 20); // ใช้ varchar และกำหนดความยาวไม่เกิน 20 ตัวอักษร
            $table->decimal('price', 10, 2); // 10 คือจำนวน digit ทั้งหมด, 2 คือจำนวน digit หลังจุดทศนิยม
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
