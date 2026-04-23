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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->enum('type', ['Pendapatan', 'Belanja', 'Pembiayaan']);
            $table->string('category');
            $table->bigInteger('amount');
            $table->bigInteger('planned_amount')->nullable();
            $table->string('volume')->nullable();
            $table->string('satuan')->nullable();
            $table->string('output')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
