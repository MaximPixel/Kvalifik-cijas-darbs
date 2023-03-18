<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Eloquent\Builder;

class QueryMacroServiceProvider extends ServiceProvider {

    public function register(): void {
        Builder::macro("firstCode", function ($code) {
            return $this->where("code", $code)->first();
        });
        Builder::macro("firstCodeOrFail", function ($code) {
            return $this->where("code", $code)->firstOrFail();
        });
    }
}
