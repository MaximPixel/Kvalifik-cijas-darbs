<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Storage;

use App\Models\PrintModel;

use PHPSTL\Reader\STLReader;

class CalculateModel implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $printModelId;

    public function __construct($printModelId) {
        $this->printModelId = $printModelId;
    }

    public function handle(): void {
        $printModel = PrintModel::findOrFail($this->printModelId);

        $stlFilepath = Storage::disk("models")->path($printModel->getCode());

        $reader = STLReader::forFile($stlFilepath);
        $reader->setHandler(new \PHPSTL\Handler\DimensionsHandler);
        $dimensions = $reader->readModel();
        $reader = STLReader::forFile($stlFilepath);
        $reader->setHandler(new \PHPSTL\Handler\VolumeHandler);
        $volume = $reader->readModel();

        $length = $dimensions->length;
        $width = $dimensions->width;
        $height = $dimensions->height;
        $diameter = $dimensions->bounding_diameter;

        $printModel->length = $length;
        $printModel->width = $width;
        $printModel->height = $height;
        $printModel->diameter = $diameter;
        $printModel->volume = $volume;
        $printModel->save();
    }
}
