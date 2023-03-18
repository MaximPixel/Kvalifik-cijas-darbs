<?php

namespace App\Models;

trait HasCodeRoute {

    public function getRoute() {
        $classKebab = str(basename(__CLASS__))->kebab();
        return route("model.$classKebab", ["code" => $this->getCode()]);
    }
}