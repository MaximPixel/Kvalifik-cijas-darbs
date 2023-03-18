<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Models\PrintModel;

use PHPSTL\Reader\STLReader;

class PrintModelController extends Controller {

    public function view(Request $request) {
        if ($request->has("action")) {
            $action = $request->query("action");

            if ($action == "create") {
                return view("model.print-model.create");
            }
        }
    }

    public function post(Request $request) {
        if ($request->has("action")) {
            $action = $request->query("action");

            if ($action == "create") {
                $data = $request->validate([
                    "modelFile" => "file",
                ]);

                $printModel = new PrintModel;
                $printModel->length = 0;
                $printModel->width = 0;
                $printModel->height = 0;
                $printModel->diameter = 0;
                $printModel->volume = 0;
                $printModel->save();

                $filename = $printModel->getCode();
                $storage = Storage::disk("models");
                $storage->put($filename, file_get_contents($data["modelFile"]));

                $reader = STLReader::forFile($storage->path($filename));
                $reader->setHandler(new \PHPSTL\Handler\DimensionsHandler);
                $dimensions = $reader->readModel();
                $reader = STLReader::forFile($storage->path($filename));
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

                return redirect()->route("index");
            }
        }
    }
}
