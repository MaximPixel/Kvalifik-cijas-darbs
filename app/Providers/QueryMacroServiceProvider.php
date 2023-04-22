<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Builder;

class QueryMacroServiceProvider extends ServiceProvider {

    public function register(): void {
        Builder::macro("firstCode", function (string $code) {
            return $this->where("code", $code)->first();
        });
        Builder::macro("firstCodeOrFail", function (string $code) {
            return $this->where("code", $code)->firstOrFail();
        });

        // Manf service macros
        Builder::macro("whereServiceCanPrint", function (\App\Models\PrintModel $model) {
            return $this->whereHas("manfServicePrinters", function ($query) use ($model) {
                $query->whereHas("printer", function ($query) use ($model) {
                    $query->wherePrinterCanPrint($model);
                });
            });
        });

        // Printer macros
        Builder::macro("wherePrinterCanPrint", function (\App\Models\PrintModel $model) {
            return $this
                ->where(function ($query) use ($model) {
                    $query->where(function ($query) use ($model) {
                        $query
                            ->whereHas("printerFeats", function ($query) use ($model) {
                                $query->whereHas("printerFeatValue", function ($query) use ($model) {
                                    $query->whereHas("printerFeatType", function ($query) use ($model) {
                                        $query->where("decimal_value", ">", $model->length)->where("name", "print-volume-x");
                                    });
                                });
                            })
                            ->whereHas("printerFeats", function ($query) use ($model) {
                                $query->whereHas("printerFeatValue", function ($query) use ($model) {
                                    $query->whereHas("printerFeatType", function ($query) use ($model) {
                                        $query->where("decimal_value", ">", $model->width)->where("name", "print-volume-y");
                                    });
                                });
                            });
                    })
                    ->orWhereHas("printerFeats", function ($query) use ($model) {
                        $query->whereHas("printerFeatValue", function ($query) use ($model) {
                            $query->whereHas("printerFeatType", function ($query) use ($model) {
                                $query->where("decimal_value", ">", $model->diameter)->where("name", "print-volume-d");
                            });
                        });
                    });
                })
                ->whereHas("printerFeats", function ($query) use ($model) {
                    $query->whereHas("printerFeatValue", function ($query) use ($model) {
                        $query->whereHas("printerFeatType", function ($query) use ($model) {
                            $query->where("decimal_value", ">", $model->height)->where("name", "print-volume-z");
                        });
                    });
                });
        });
    }
}
