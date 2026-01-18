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
        Schema::create('lawyers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('fullName');
            $table->string('seconedName');
            $table->string('motherName');
            $table->string('phone');
            $table->date('birthDate')->nullable();
            $table->string('secretariat')->commit('القيد');
            $table->string('nationalNumer')->commit('الرقم الوطني');
            $table->string('status');
            $table->date('joinDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lawyers');
    }
};
