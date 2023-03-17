<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $faker;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->faker = \Faker\Factory::create();
        $users = $this->createUsers();
        $printers = $this->createPrinters($users);
        [$featTypes, $featValues] = $this->createPrinterFeatTypes();
        $this->createPrinterFeats($printers, $featTypes, $featValues);
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

    private function createPrinters($users, $count = 10) {
        $printers = collect();
        for ($i = 0; $i < $count; $i++) {
            $printer = new \App\Models\Printer;
            $printer->creator_user_id = $users->random()->id;
            $printer->name = $this->faker->text();
            $printer->description = $this->faker->text();
            $printer->manufacturer = "creality";
            $printer->save();
            $printers->push($printer);
        }
        return $printers;
    }

    private function createPrinterFeatTypes($count = 5) {
        $featTypes = collect();
        $featValues = collect();

        for ($i = 0; $i < $count; $i++) {
            $featType = new \App\Models\PrinterFeatType;
            $featType->required = $this->faker->boolean();
            $featType->name = $this->faker->sentence();
            $featType->save();
            $featTypes->push($featType);

            for ($j = 0; $j < $this->faker->randomDigitNotNull(); $j++) {
                $featValue = new \App\Models\PrinterFeatValue;
                $featValue->printer_feat_type_id = $featType->id;
                $featValue->name = $this->faker->sentence();
                $featValue->description = $this->faker->sentence();
                $featValue->save();
                $featValues->push($featValue);
            }

            $featType->default_printer_feat_value_id =
                $featValues->where("printer_feat_type_id", $featType->id)->random()->id;
            $featType->save();
        }
        return [$featTypes, $featValues];
    }

    private function createPrinterFeats($printers, $featTypes, $featValues) {
        foreach ($printers as $printer) {
            foreach ($featTypes as $featType) {
                if ($featType->required) {
                    $printerFeat = new \App\Models\PrinterFeat;
                    $printerFeat->printer_id = $printer->id;
                    $printerFeat->printer_feat_value_id = $featValues
                        ->where("printer_feat_type_id", $featType->id)->random()->id;
                    $printerFeat->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
