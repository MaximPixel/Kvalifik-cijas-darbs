<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info(json_encode([
            [
                "measure_type" => "accuracy",
                "name" => "print-resolution",
                "description" => "",
            ],
            [
                "measure_type" => "length",
                "name" => "print-volume-x",
                "description" => "",
            ],
            [
                "measure_type" => "length",
                "name" => "print-volume-y",
                "description" => "",
            ],
            [
                "measure_type" => "length",
                "name" => "print-volume-z",
                "description" => "",
            ],
            [
                "measure_type" => "length",
                "name" => "printer-layer-height-min",
                "description" => "",
            ],
            [
                "measure_type" => "length",
                "name" => "printer-layer-height-max",
                "description" => "",
            ],
            [
                "measure_type" => "diameter",
                "name" => "filament-diameter",
                "description" => "",
            ],
            [
                "measure_type" => "temperature",
                "name" => "nozzle-temperature-max",
                "description" => "",
            ],
            [
                "measure_type" => "temperature",
                "name" => "bed-temperature-max",
                "description" => "",
            ],
        ], JSON_PRETTY_PRINT));
    }
}
