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
        Schema::create('printer_feats', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Printer::class)->constrained();
            $table->foreignIdFor(\App\Models\PrinterFeatValue::class)->constrained();
            $table->unsignedInteger("count")->default(1);

            $table->primary(["printer_id", "printer_feat_value_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_feats');
    }
};
