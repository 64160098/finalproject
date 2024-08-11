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
        Schema::create('product_sales_histories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('product_name', 255);
            $table->integer('quuantity_products_sold')->length(11);
            $table->string('unit', 255);
            $table->string('cost_unit', 255);
            $table->string('total', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales_histories');
    }
};
