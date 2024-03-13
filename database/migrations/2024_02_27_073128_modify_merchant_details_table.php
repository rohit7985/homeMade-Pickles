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
                // Drop the 'email' column
                Schema::table('merchant_details', function (Blueprint $table) {
                    $table->dropColumn('email');
                });
        
                // Add the 'merchant_id' column
                Schema::table('merchant_details', function (Blueprint $table) {
                    $table->unsignedBigInteger('merchant_id')->nullable();
                    $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Reverse the changes made in the 'up' method
         Schema::table('merchant_details', function (Blueprint $table) {
        });
    }
};
