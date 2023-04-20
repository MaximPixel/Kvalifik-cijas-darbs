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
        Schema::create('printer_feat_type_langs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\PrinterFeatType::class);
            $table->foreignIdFor(\App\Models\Lang::class);
            $table->text("description");
            $table->timestamps();

            $table->unique(["printer_feat_type_id", "lang_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_feat_types');
    }
};
