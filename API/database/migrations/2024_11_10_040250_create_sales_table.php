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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('seller_id');
            $table->date('date_sale');
            $table->decimal('total', 8, 2); // Especifica precisión y escala
            $table->integer('is_active');
            $table->timestamps();

            // Agregar las claves foráneas
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('seller_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
