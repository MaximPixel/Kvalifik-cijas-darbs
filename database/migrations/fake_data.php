<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private $faker;

    private $users, $featTypes, $printers, $manfs, $printMaterials, $services;
    private $orderStatuses;

    public function up(): void {
        $user = new \App\Models\User;
        $user->name = "user";
        $user->email = "user@gmail.com";
        $user->password = "$2y$10\$KL.WiHnyABT.kCBWkNECH.a6.V8zV5oidlzBK0gyLjExtRVH/oeOi";
        $user->save();

        $user = new \App\Models\User;
        $user->name = "admin";
        $user->email = "admin@gmail.com";
        $user->password = "$2y$10\$KL.WiHnyABT.kCBWkNECH.a6.V8zV5oidlzBK0gyLjExtRVH/oeOi";
        $user->user_group_id = 2;
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

    private function createUsers($count = 50) {
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
                "description" => [
                    "en" => "The parameter refers to the minimum size of an object that can be printed on a 3D printer. The higher the resolution, the more detailed objects can be printed.",
                    "lv" => "Parametrs attiecas uz minimālo objekta izmēru, kas var tikt izdrukāts uz 3D printeri. Jo augstāka izšķirtspēja, jo detalizētāki objekti var tikt izdrukāti.",
                    "ru" => "Параметр относится к минимальному размеру объекта, который может быть распечатан на 3D принтере. Чем выше разрешение, тем более детализированные объекты могут быть распечатаны.",
                ],
            ],
            [
                "measure_type" => "length",
                "name" => "print-volume-x",
                "description" => [
                    "en" => "Parameter determines the maximum length of an object that can be printed on a 3D printer along the X-axis.",
                    "lv" => "Parametrs nosaka maksimālo objekta garumu, kas var tikt izdrukāts uz 3D printeri pa X asi.",
                    "ru" => "Параметр определяет максимальную длину объекта, который может быть распечатан на 3D принтере вдоль оси X.",
                ],
            ],
            [
                "measure_type" => "length",
                "name" => "print-volume-y",
                "description" => [
                    "en" => "Parameter determines the maximum length of an object that can be printed on a 3D printer along the Y-axis.",
                    "lv" => "Parametrs nosaka maksimālo objekta garumu, kas var tikt izdrukāts uz 3D printeri pa Y asi.",
                    "ru" => "Параметр определяет максимальную длину объекта, который может быть распечатан на 3D принтере вдоль оси Y.",
                ],
            ],
            [
                "measure_type" => "length",
                "name" => "print-volume-z",
                "description" => [
                    "en" => "Parameter determines the maximum length of an object that can be printed on a 3D printer along the Z-axis.",
                    "lv" => "Parametrs nosaka maksimālo objekta garumu, kas var tikt izdrukāts uz 3D printeri pa Z asi.",
                    "ru" => "Параметр определяет максимальную длину объекта, который может быть распечатан на 3D принтере вдоль оси Z.",
                ],
            ],
            [
                "measure_type" => "length",
                "name" => "printer-layer-height-min",
                "description" => [
                    "en" => "Determines the minimum thickness of the material layer that the printer will apply when printing an object. The lower the value, the more precise the print and the longer the print time.",
                    "lv" => "Nosaka minimālo materiāla slāņa biezumu, ko 3D printeris uzklās, kad tiek drukāts objekts. Jo zemāka ir šī vērtība, jo precīzāka ir druka, bet ilgāks ir drukas laiks.",
                    "ru" => "Определяет, какую минимальную толщину слоя материала будет наносить принтер при печати объекта. Чем меньше значение, тем точнее и дольше длится печать.",
                ],
            ],
            [
                "measure_type" => "length",
                "name" => "printer-layer-height-max",
                "description" => [
                    "en" => "Determines the maximum thickness of the material layer that the printer will apply when printing an object. The higher the value, the lower the quality and the faster the print time.",
                    "lv" => "Nosaka maksimālo materiāla slāņa biezumu, ko 3D printeris uzklās, kad tiek drukāts objekts. Jo augstāka ir šī vērtība, jo zemāka ir kvalitāte un ātrāks ir drukas laiks.",
                    "ru" => "Определяет, какую максимальную толщину слоя материала будет наносить принтер при печати объекта. Чем больше значение, тем меньше качество и быстее длится печать.",
                ],
            ],
            [
                "measure_type" => "diameter",
                "name" => "nozzle-diameter",
                "description" => [
                    "en" => "",
                    "lv" => "",
                    "ru" => "",
                ],
            ],
            [
                "measure_type" => "diameter",
                "name" => "filament-diameter",
                "description" => [
                    "en" => "Determines the diameter of the material filament used for printing. Most commonly, this is 1.75 mm",
                    "lv" => "Noteic materiāla filaments, kas tiek izmantots drukāšanai, diametru. Visbiežāk tas ir 1.75 mm.",
                    "ru" => "Определяет диаметр нити материала, который используется при печати. Чаще всего это 1.75 мм.",
                ],
            ],
            [
                "measure_type" => "temperature",
                "name" => "nozzle-temperature-max",
                "description" => [
                    "en" => "Determines the maximum temperature of the 3D printer nozzle. This affects the materials that can be used for printing.",
                    "lv" => "Noteic 3D printeris izmantojamā sukas maksimālo temperatūru. Tas ietekmē materiālus, kas var tikt izmantoti drukāšanai.",
                    "ru" => "Определяет максимальную температуру сопла 3д принтера. Влияет на то, какие материалы возможно использовать для печати.",
                ],
            ],
            [
                "measure_type" => "temperature",
                "name" => "bed-temperature-max",
                "description" => [
                    "en" => "Determines the maximum temperature of the 3D printer bed. This affects material selection and how well the selected material adheres to the bed.",
                    "lv" => "Noteic 3D printera gultnes maksimālo temperatūru. Tas ietekmē materiāla izvēli un to, cik labi izvēlētais materiāls piestiprinās pie gultnes.",
                    "ru" => "Определяет максимальную температуру стола 3д принтера. Влияет на выбор материала и на прилипание выбранного материала.",
                ],
                "required" => false,
            ],
        ];

        $featTypes = collect();

        foreach ($data as $row) {
            $printerFeatType = new \App\Models\PrinterFeatType;
            $printerFeatType->name = $row["name"];
            $printerFeatType->measure_type = $row["measure_type"];
            $printerFeatType->required = $row["required"] ?? true;
            $printerFeatType->save();

            foreach ($row["description"] as $langCode => $description) {
                $printerFeatTypeLang = new \App\Models\PrinterFeatTypeLang;
                $printerFeatTypeLang->printer_feat_type_id = $printerFeatType->id;
                $printerFeatTypeLang->lang_id = \App\Models\Lang::where("name", $langCode)->first()->id;
                $printerFeatTypeLang->description = $description;
                $printerFeatTypeLang->save();
            }

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
            [
                "name" => "Anycubic Kobra Go",
                "description" => "",
                "manufacturer" => "ANYCUBIC",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [220, "mm"],
                    "print-volume-y" => [220, "mm"],
                    "print-volume-z" => [250, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.4, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [110, "°C"],
                ],
                "image" => "https://www.anycubic.com/cdn/shop/products/KobraGo_1_7977c357-eeca-49ab-8746-f77ba820a396_540x.jpg?v=1680332374",
            ],
            [
                "name" => "Anycubic Kobra Plus",
                "description" => "",
                "manufacturer" => "ANYCUBIC",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [300, "mm"],
                    "print-volume-y" => [300, "mm"],
                    "print-volume-z" => [350, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.4, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
                "image" => "https://www.anycubic.com/cdn/shop/products/KobraPlus_1_540x.jpg?v=1680332368",
            ],
            [
                "name" => "Vyper",
                "description" => "",
                "manufacturer" => "ANYCUBIC",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [245, "mm"],
                    "print-volume-y" => [245, "mm"],
                    "print-volume-z" => [260, "mm"],
                    "printer-layer-height-min" => [0.1, "mm"],
                    "printer-layer-height-max" => [0.4, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [260, "°C"],
                    "bed-temperature-max" => [110, "°C"],
                ],
                "image" => "https://www.anycubic.com/cdn/shop/products/KobraGo_1_7977c357-eeca-49ab-8746-f77ba820a396_540x.jpg?v=1680332374",
            ],
            [
                "name" => "Mega X",
                "description" => "",
                "manufacturer" => "ANYCUBIC",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [300, "mm"],
                    "print-volume-y" => [300, "mm"],
                    "print-volume-z" => [305, "mm"],
                    "printer-layer-height-min" => [0.05, "mm"],
                    "printer-layer-height-max" => [0.3, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [250, "°C"],
                    "bed-temperature-max" => [90, "°C"],
                ],
                "image" => "https://www.anycubic.com/cdn/shop/products/01_ba98cb9d-2895-40c2-a0d0-c458a7bc4a3c_1800x1800.jpg?v=1654067392",
            ],
            [
                "name" => "Original Prusa MK4",
                "description" => "",
                "manufacturer" => "PRUSA",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [250, "mm"],
                    "print-volume-y" => [210, "mm"],
                    "print-volume-z" => [220, "mm"],
                    "printer-layer-height-min" => [0.05, "mm"],
                    "printer-layer-height-max" => [0.3, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [300, "°C"],
                    "bed-temperature-max" => [120, "°C"],
                ],
                "image" => "https://cdn.prusa3d.com/content/images/product/default/5508.jpg",
            ],
            [
                "name" => "Original Prusa MINI+",
                "description" => "",
                "manufacturer" => "PRUSA",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [180, "mm"],
                    "print-volume-y" => [180, "mm"],
                    "print-volume-z" => [180, "mm"],
                    "printer-layer-height-min" => [0.05, "mm"],
                    "printer-layer-height-max" => [0.25, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [280, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
                "image" => "https://cdn.prusa3d.com/content/images/product/default/2280.jpg",
            ],
            [
                "name" => "Original Prusa XL",
                "description" => "",
                "manufacturer" => "PRUSA",
                "feats" => [
                    "print-resolution" => [0.1, "mm"],
                    "print-volume-x" => [360, "mm"],
                    "print-volume-y" => [360, "mm"],
                    "print-volume-z" => [360, "mm"],
                    "printer-layer-height-min" => [0.05, "mm"],
                    "printer-layer-height-max" => [0.25, "mm"],
                    "nozzle-diameter" => [0.4, "mm"],
                    "filament-diameter" => [1.75, "mm"],
                    "nozzle-temperature-max" => [280, "°C"],
                    "bed-temperature-max" => [100, "°C"],
                ],
                "image" => "https://cdn.prusa3d.com/content/images/product/default/5422.jpg",
            ],
        ];
        foreach ($printersData as $data) {
            $printer = $this->createPrinter(
                $data["name"],
                $data["description"],
                $data["manufacturer"],
                $data["feats"],
            );

            if (isset($data["image"])) {
                $printerImage = \App\Models\Image::upload($data["image"]);
                $printer->image_id = $printerImage->id;
                $printer->save();
            }

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

            $featValue = \App\Models\PrinterFeatValue::getOrCreate([
                "name" => $value,
                "decimal_value" => $value,
                "unit" => $unit,
            ], $featType);

            $printerFeat = new \App\Models\PrinterFeat;
            $printerFeat->printer_id = $printer->id;
            $printerFeat->printer_feat_value_id = $featValue->id;
            $printerFeat->save();
        }

        return $printer;
    }

    private function createManfs($count = 40) {
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
