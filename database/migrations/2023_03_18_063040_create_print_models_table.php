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
        Schema::create('print_models', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->nullable()->unique();
            $table->float("length");
            $table->float("width");
            $table->float("height");
            $table->float("diameter");
            $table->float("volume");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_models');
    }
};
