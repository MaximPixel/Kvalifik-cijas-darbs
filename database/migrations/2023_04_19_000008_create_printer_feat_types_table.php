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
        Schema::create('printer_feat_types', function (Blueprint $table) {
            $table->id();
            $table->string("code")->collation("utf8mb4_bin")->nullable()->unique();
            $table->string("name")->index();
            $table->boolean("deleted")->default(false);
            $table->boolean("required")->default(false);
            $table->boolean("allow_many_values")->default(true);
            $table->string("measure_type");
            $table->foreignIdFor(\App\Models\User::class, "creator_user_id")->nullable()->constrained("users");
            $table->timestamps();
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
