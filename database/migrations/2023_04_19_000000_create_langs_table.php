<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('langs', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        $this->createLang("en");
        $this->createLang("lv");
        $this->createLang("ru");
    }

    protected function createLang(string $name) {
        $lang = new \App\Models\Lang;
        $lang->name = $name;
        $lang->save();
        return $lang;
    }

    public function down(): void {
        Schema::dropIfExists('langs');
    }
};
