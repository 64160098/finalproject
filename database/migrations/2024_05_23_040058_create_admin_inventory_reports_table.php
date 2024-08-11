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
        Schema::create('admin_inventory_reports', function (Blueprint $table) {
            $table->bigIncrements('id'); // auto-incrementing ID
            $table->string('code'); // VARCHAR(255) for 'code'
            $table->string('product_name'); // VARCHAR(255) for 'product_name'
            $table->integer('quantity_inventories'); // INT for 'quantity_products_sold'
            $table->string('unit'); // VARCHAR(255) for 'unit'
            $table->decimal('cost_unit', 10, 2); // DECIMAL for 'cost_unit'
            $table->decimal('total', 10, 2); // DECIMAL for 'total'
            $table->date('created_at')->nullable(); // DATE for 'created_at'
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_inventory_reports');
    }
};
