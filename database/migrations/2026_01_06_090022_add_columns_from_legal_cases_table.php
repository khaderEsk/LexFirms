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
        Schema::table('legal_cases', function (Blueprint $table) {
            $table->integer('dollar_price')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->string('syrian_prices')->nullable();
            $table->string('remaining_balance_of_payment')->nullable();
            $table->string('remaining_balance_of_expenditure')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_cases', function (Blueprint $table) {
            //
        });
    }
};
