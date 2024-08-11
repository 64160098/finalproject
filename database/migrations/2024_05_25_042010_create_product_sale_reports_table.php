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
        Schema::create('product_sale_reports', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('product_name');
            $table->integer('quantity_products_sale')->length(11);
            $table->string('unit');
            $table->float('cost_unit');
            $table->float('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sale_reports');
    }
};
