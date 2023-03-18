<?php

namespace App\Models;

trait HasCodeEditRoute {

    public function getEditRoute() {
        $classKebab = str(basename(__CLASS__))->kebab();
        return route("model.$classKebab", ["action" => "edit", "code" => $this->getCode()]);
    }
}