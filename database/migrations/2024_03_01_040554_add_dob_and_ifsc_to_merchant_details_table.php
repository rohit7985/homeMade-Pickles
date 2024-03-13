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
        Schema::table('merchant_details', function (Blueprint $table) {
                        $table->date('dob')->nullable();
                        $table->string('ifsc_code', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_details', function (Blueprint $table) {
                        $table->dropColumn('dob');
                        $table->dropColumn('ifsc_code');
        });
    }
};
