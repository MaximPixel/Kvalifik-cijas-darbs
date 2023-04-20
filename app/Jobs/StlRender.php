<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;

use App\Models\Image;
use App\Models\PrintModel;

class StlRender implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $printModelId;

    public function __construct($printModelId) {
        $this->printModelId = $printModelId;
    }

    public function handle(): void {
        $printModel = PrintModel::findOrFail($this->printModelId);
        $image = new Image;
        $image->save();

        try {
            $stlFilepath = $printModel->getPath();
            $imageFilepath = $image->getPath();

            $pythonFilepath = escapeshellarg(base_path() . "/python/stl_render.py");
            $stlFilepath = escapeshellarg($stlFilepath);
            $imageFilepath = escapeshellarg($imageFilepath);
            exec(config("python.path") . " $pythonFilepath --filepath=$stlFilepath --output=$imageFilepath");

            $printModel->image_id = $image->id;
            $printModel->save();
        } catch (\Exception $e) {
            $image->delete();
            throw $e;
        }
    }
}
