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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Connect to tenant
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            
            // OPTIONAL: Connect to reservation if you want to track which stay this is for
            // $table->foreignId('reservation_id')->constrained()->onDelete('cascade');

            $table->decimal('amount', 8, 2);
            $table->date('payment_date');
            $table->string('payment_method'); // Cash, GCash, Bank Transfer
            
            // ADDED THIS LINE: The controller needs this!
            $table->string('status')->default('unpaid'); // unpaid, paid, partial
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};