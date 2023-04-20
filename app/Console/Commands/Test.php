<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

class Test extends Command {

    protected $signature = 'app:test';

    protected $description = 'Command description';

    public function handle(): void {
        $path = base_path() . "/database/migrations";
        $files = scandir($path);

        $i = 0;

        foreach ($files as $file) {
            if ($file != "." && $file != ".." && $file != "fake_data.php") {
                $newName = "2023_04_19_" . str($i)->padLeft(6, "0") . "_" . str($file)->after("_")->after("_")->after("_")->after("_");
                rename($path . "/" . $file, $path . "/" . $newName);
                $i++;
            }
        }
    }
}
