<?php

namespace App\Models;

trait HasCodeRoute {

    public function getKebabClass() {
        return str(basename(__CLASS__))->kebab();
    }

    public function getRoute() {
        return route("model." . $this->getKebabClass(), ["code" => $this->getCode()]);
    }

    public function getActionRoute($action) {
        return route("model." . $this->getKebabClass(), ["code" => $this->getCode(), "action" => $action]);
    }
}