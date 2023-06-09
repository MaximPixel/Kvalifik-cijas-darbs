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
        Schema::create('manf_services', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->nullable()->unique();
            $table->boolean("deleted")->default(false);
            $table->foreignIdFor(\App\Models\Manf::class)->constrained();
            $table->string("name");
            $table->text("description");
            $table->decimal("price_base", 10, 4);
            $table->decimal("price_min", 10, 4);
            $table->decimal("price_per_time", 10, 4);
            $table->decimal("price_per_volume", 10, 4);
            $table->foreignIdFor(\App\Models\Image::class)->nullable()->constrained();
            $table->unsignedInteger("_orders_count")->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manf_services');
    }
};
