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
        Schema::create('manf_service_printers', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\ManfService::class)->constrained();
            $table->foreignIdFor(\App\Models\Printer::class)->constrained();
            $table->timestamps();

            $table->primary(["manf_service_id", "printer_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manf_service_printers');
    }
};
