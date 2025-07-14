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

           Schema::create('teas', function (Blueprint $table) {
        $table->id();
        $table->enum('tea_grade', ['BOP', 'FBOP', 'PEKOE', 'DUST'])->default('BOP');
        $table->decimal('buy_price', 8, 2);
        $table->decimal('selling_price', 8, 2);
        $table->date('date');
        $table->boolean('status')->default(true);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teas');
    }
};
