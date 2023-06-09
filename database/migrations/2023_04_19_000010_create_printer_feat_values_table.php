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
        Schema::create('printer_feat_values', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->unique();
            $table->boolean("deleted")->default(false);
            $table->foreignIdFor(\App\Models\PrinterFeatType::class)->constrained();
            $table->string("value_reference")->unique();
            $table->string("name");
            $table->text("description");
            $table->float("decimal_value")->nullable();
            $table->boolean("boolean_value")->nullable();
            $table->string("unit")->nullable();
            $table->foreignIdFor(\App\Models\User::class, "creator_user_id")->nullable()->constrained("users");
            $table->timestamps();
        });

        Schema::table('printer_feat_types', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\PrinterFeatValue::class, "default_printer_feat_value_id")
                ->nullable()->constrained("printer_feat_values");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_feat_values');

        Schema::table('printer_feat_types', function (Blueprint $table) {
            $table->dropForeign(["default_printer_feat_value_id"]);
            $table->dropColumn("default_printer_feat_value_id");
        });
    }
};
