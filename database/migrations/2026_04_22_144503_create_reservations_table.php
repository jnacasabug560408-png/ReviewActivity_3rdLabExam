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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        // Foreign keys connecting to Rooms and Tenants
        $table->foreignId('room_id')->constrained()->onDelete('cascade');
        $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
        $table->date('start_date');
        $table->date('end_date')->nullable();
        $table->string('status')->default('pending'); // pending, active, completed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
