<?php

namespace App\Models;

trait HasCodeRoute {

    public function getKebabClass() {
        return str(basename(__CLASS__))->kebab();
    }

    public function getRoute($params = null) {
        $params = collect($params)->merge(collect(["code" => $this->getCode()]))->toArray();
        return route("model." . $this->getKebabClass(), $params);
    }

    public function getActionRoute($action, $params = null) {
        $params = collect($params)->merge(collect(["action" => $action]))->toArray();
        return $this->getRoute($params);
    }
}