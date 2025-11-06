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
        Schema::create('l_s_cases', function (Blueprint $table) {
            $table->id();
            $table->string('discountName'); // الخصم arr
            $table->string('type')->comment('تقاضي أو استشارة'); // ـقاضي او استشاررة
            $table->string('unit');
            $table->string('cort');
            $table->string('caseNumber');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l_s_cases');
    }
};
