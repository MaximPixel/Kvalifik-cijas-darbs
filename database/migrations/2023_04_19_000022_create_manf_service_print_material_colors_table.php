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
        Schema::create('manf_service_print_material_colors', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\ManfService::class)->constrained();
            $table->unsignedBigInteger("print_material_color_id");
            $table->timestamps();

            $table->foreign("print_material_color_id")->references("id")->on("print_material_colors")->name("manf_service_pmc_pmc_id_foreign");
            $table->primary(["manf_service_id", "print_material_color_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manf_service_print_material_colors');
    }
};
