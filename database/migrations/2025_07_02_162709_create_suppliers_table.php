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
    Schema::create('suppliers', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('tea_id');

    // Changed register_id to string
    $table->string('register_id')->unique();

    $table->string('supplier_name');
    $table->text('address');
    $table->string('phone_number');

    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->timestamps();

    $table->foreign('tea_id')->references('id')->on('teas')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
