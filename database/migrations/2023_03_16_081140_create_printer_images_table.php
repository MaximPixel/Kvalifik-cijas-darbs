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
        Schema::create('printer_images', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Printer::class)->constrained();
            $table->foreignIdFor(\App\Models\Image::class)->constrained();
            $table->timestamps();

            $table->primary(["printer_id", "image_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_images');
    }
};
