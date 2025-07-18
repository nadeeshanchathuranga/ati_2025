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
        Schema::create('fertilizer_sale_items', function (Blueprint $table) {
           $table->id();
            $table->foreignId('fertilizer_sale_id')->constrained('fertilizer_sales')->onDelete('cascade');
            $table->foreignId('fertilizer_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity_grams', 10, 2);
            $table->decimal('unit_price', 10, 2); // per gram
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizer_sale_items');
    }
};
