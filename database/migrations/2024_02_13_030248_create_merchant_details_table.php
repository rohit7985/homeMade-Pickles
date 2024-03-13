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
        Schema::create('merchant_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile_number')->nullable();
            $table->text('address');
            $table->string('GSTIN');
            $table->string('panNumber');
            $table->string('bankName');
            $table->string('accountNo');
            $table->timestamps();
    
            // You also need to add the foreign key column here.
            // Assuming the column name is `merchant_id`.
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_details');
    }
};
