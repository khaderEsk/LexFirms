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
        Schema::create('legal_cases', function (Blueprint $table) {
            $table->id();
            $table->string('attribute');
            $table->string('second_party_name')->nullable();
            $table->tinyInteger('progress')->default(0);
            $table->string('court')->nullable();
            $table->string('department')->nullable();
            $table->string('base_number')->nullable();
            $table->string('name_case');
            $table->text('subject');
            $table->enum('case_type', ['ح', 'ش', 'د']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_cases');
    }
};
