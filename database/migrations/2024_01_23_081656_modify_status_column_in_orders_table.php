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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [0, 1, 2])->default(0)->after('total_amount')->comment('0: Pending, 1: Completed, 2: Canceled')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [0, 1, 2])->default(0)->after('total_amount')->comment('0: Pending, 1: Approved, 2: Disapproved')->change();
        });
    }
};
