<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

class Test extends Command {

    protected $signature = 'app:test';

    protected $description = 'Command description';

    public function handle(): void {
        dd(base_path() . "/python/stl_render.py");
        $modelFilepath = Storage::disk("models")->path("TuQayi3BZkVqENB");
        $imageFilepath = Storage::disk("images")->path("JJ1FGk7Dbxg87Jh");
        $a = null;
        $b = null;
        $modelFilepath = escapeshellarg($modelFilepath);
        $imageFilepath = escapeshellarg($imageFilepath);
        $c = exec("python python//stl_render.py --filepath=$modelFilepath --output=$imageFilepath", $a, $b);
    }
}
