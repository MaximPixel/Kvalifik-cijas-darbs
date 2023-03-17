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
        Schema::create('manf_printers', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Manf::class)->constrained();
            $table->foreignIdFor(\App\Models\Printer::class)->constrained();
            $table->unsignedInteger("count");
            $table->timestamps();

            $table->primary(["manf_id", "printer_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manf_printers');
    }
};
