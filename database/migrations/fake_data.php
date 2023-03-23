<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private $faker;

    private $users, $featTypes, $printers, $manfs, $printMaterials, $services;

    public function up(): void {
        $user = new \App\Models\User;
        $user->name = "testtest";
        $user->email = "test@test.test";
        $user->password = "$2y$10\$KL.WiHnyABT.kCBWkNECH.a6.V8zV5oidlzBK0gyLjExtRVH/oeOi";
        $user->save();

        $this->faker = \Faker\Factory::create();
        $this->users = $this->createUsers();
        $this->featTypes = $this->createFeatTypes();
        $this->printers = $this->createPrinters();
        $this->manfs = $this->createManfs();
        $this->printMaterials = $this->createPrintMaterials();
        $this->services = $this->createServices();
    }

    private function createPrintMaterials() {
        $data = [
            [
                "name" => "Ender PLA",
                "description" => "",
                "manufacturer" => "CREALITY",
                "type" => "PLA",
                "min_temp" => 190,
                "max_temp" => 230,
                "colors" => ["WHITE", "FFFFFF", "BLACK", "000000", "RED", "FF0000", "YELLOW", "FFFF00", "GRAY", "808080", "BLUE", "0000FF"],
            ],
            [
                "name" => "CR PLA",
                "description" => "",
                "manufacturer" => "CREALITY",
                "type" => "PLA",
                "min_temp" => 190,
                "max_temp" => 230,
                "colors" => ["WHITE", "FFFFFF", "BLACK", "000000", "RED", "FF0000", "YELLOW", "FFFF00", "GRAY", "808080", "BLUE", "0000FF", "GREEN", "00FF00", "SILVER", "D3D3D3"],
            ],
            [
                "name" => "HP-Ultra PLA",
                "description" => "",
                "manufacturer" => "CREALITY",
                "type" => "PLA",
                "min_temp" => 190,
                "max_temp" => 230,
                "colors" => ["BLUE", "0000FF", "GREEN", "00FF00", "GRAY", "808080", "WHITE", "FFFFFF", "BLACK", "000000", "RED", "FF0000", "ORANGE", "FFA500"],
            ],
        ];

        $printMaterials = collect();

        foreach ($data as $row) {
            $printMaterial = new \App\Models\PrintMaterial;
            foreach ($row as $key => $value) {
                if ($key != "colors") {
                    $printMaterial->$key = $value;
                }
            }
            $printMaterial->save();

            for ($i = 0; $i < count($row["colors"]) / 2; $i++) {
                $printMaterialColor = new \App\Models\PrintMaterialColor;
                $printMaterialColor->print_material_id = $printMaterial->id;
                $printMaterialColor->name = $row["colors"][$i * 2];
                $printMaterialColor->hex = $row["colors"][$i * 2 + 1];
                $printMaterialColor->save();
            }
            $printMaterials->push($printMaterial);
        }

        return $printMaterials;
    }

    private function createUsers($count = 5) {
        $users = collect();
        for ($i = 0; $i < $count; $i++) {
            $user = new \App\Models\User;
            $user->name = $this->faker->name();
            $user->email = $this->faker->email();
            $user->password = $user->name;
            $user->save();
            $users->push($user);
        }
        return $users;
    }

    private function createFeatTypes() {
        $data = [
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
        ];

        $featTypes = collect();

        foreach ($data as $row) {
            $printerFeatType = new \App\Models\PrinterFeatType;
            foreach ($row as $key => $value) {
                $printerFeatType->$key = $value;
            }
            $printerFeatType->required = true;
            $printerFeatType->save();
            $featTypes->push($printerFeatType);
        }

        return $featTypes;
    }

    private function createPrinters() {
        $printers = collect();
        $printersData = [
            [
                "name" => "Ender-5 S1",
                "description" => "",
                "manufacturer" => "CREALITY",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [220, "mm"],
                    "print-volume-y" => [220, "mm"],
                    "print-volume-z" => [220, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.35, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [300, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
            ],
            [
                "name" => "Ender-3 S1 Pro",
                "description" => "",
                "manufacturer" => "CREALITY",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [220, "mm"],
                    "print-volume-y" => [220, "mm"],
                    "print-volume-z" => [270, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.35, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [300, "°C"],
                    "bed-temperature-max" => [110, "°C"],
                ],
            ],
            [
                "name" => "Ender-3 S1",
                "description" => "",
                "manufacturer" => "CREALITY",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [220, "mm"],
                    "print-volume-y" => [220, "mm"],
                    "print-volume-z" => [270, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.35, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
            ],
            [
                "name" => "Ender-3 Max Neo",
                "description" => "",
                "manufacturer" => "CREALITY",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [300, "°C"],
                    "print-volume-y" => [300, "°C"],
                    "print-volume-z" => [320, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.35, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
            ],
            [
                "name" => "Ender-3 V2 Neo",
                "description" => "",
                "manufacturer" => "CREALITY",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [220, "mm"],
                    "print-volume-y" => [220, "mm"],
                    "print-volume-z" => [250, "mm"],
                    "printer-layer-height-min" => 0.05,
                    "printer-layer-height-max" => [0.35, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
            ],
            [
                "name" => "Ender-6",
                "description" => "",
                "manufacturer" => "CREALITY",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [250, "mm"],
                    "print-volume-y" => [250, "mm"],
                    "print-volume-z" => [400, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
            ],
        ];
        foreach ($printersData as $data) {
            $printer = $this->createPrinter(
                $data["name"],
                $data["description"],
                $data["manufacturer"],
                $data["feats"],
            );
            $printers->push($printer);
        }
        return $printers;
    }

    private function createPrinter($name, $description, $manufacturer, $feats) {
        $printer = new \App\Models\Printer;
        $printer->name = $name;
        $printer->description = $description;
        $printer->manufacturer = $manufacturer;
        $printer->save();

        foreach ($feats as $key => $value) {
            $featType = \App\Models\PrinterFeatType::where("name", $key)->first();

            if (is_array($value)) {
                $arr = $value;
                $value = $arr[0];
                $unit = $arr[1];
            } else {
                $unit = null;
            }

            $featValue = new \App\Models\PrinterFeatValue;
            $featValue->printer_feat_type_id = $featType->id;
            $featValue->name = $value;
            $featValue->description = "";
            $featValue->decimal_value = $value;
            $featValue->unit = $unit;
            $featValue->save();

            $printerFeat = new \App\Models\PrinterFeat;
            $printerFeat->printer_id = $printer->id;
            $printerFeat->printer_feat_value_id = $featValue->id;
            $printerFeat->save();
        }

        return $printer;
    }

    private function createManfs($count = 4) {
        $manfs = collect();

        for ($i = 0; $i < $count; $i++) {
            $manf = new \App\Models\Manf;
            $manf->name = "MANF $i";
            $manf->email = $this->faker->email();
            $manf->save();
            $manfs->push($manf);

            $manfRole = new \App\Models\ManfRole;
            $manfRole->manf_id = $manf->id;
            $manfRole->name = "Creator";
            $manfRole->save();

            $manfRoleUser = new \App\Models\ManfRoleUser;
            $manfRoleUser->manf_role_id = $manfRole->id;
            $manfRoleUser->user_id = $this->users->random()->id;
            $manfRoleUser->save();
        }

        return $manfs;
    }

    private function createServices() {
        $services = collect();

        foreach ($this->manfs as $i => $manf) {
            $service = new \App\Models\ManfService;
            $service->manf_id = $manf->id;
            $service->name = "SERVICE $i";
            $service->description = "SERVICE $i DESCRIPTION";
            $service->price_base = 1;
            $service->price_min = 1;
            $service->price_per_volume = 1;
            $service->price_per_time = 1;
            $service->save();

            $servicePrinter = new \App\Models\ManfServicePrinter;
            $servicePrinter->manf_service_id = $service->id;
            $servicePrinter->printer_id = $this->printers->random()->id;
            $servicePrinter->save();

            $servicePrintMaterialColor = new \App\Models\ManfServicePrintMaterialColor;
            $servicePrintMaterialColor->manf_service_id = $service->id;
            $servicePrintMaterialColor->print_material_color_id = $this->printMaterials->random()->printMaterialColors->random()->id;
            $servicePrintMaterialColor->save();
        }

        return $services;
    }

    public function down(): void {}
};
