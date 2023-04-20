<?php

namespace App\Classes;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Arr;

class CustomPaginator extends LengthAwarePaginator {

    protected $child;

    public function __construct(LengthAwarePaginator $child) {
        parent::__construct($child->items(), $child->total(), $child->perPage(), $child->currentPage(), $child->getOptions());
        $this->child = $child;
    }

    public function url($page) {
        if ($page <= 0) {
            $page = 1;
        }

        if ($page > 1) {
            return parent::url($page);
        }

        $parameters = [];

        if (count($this->query) > 0) {
            $parameters = array_merge($this->query, $parameters);
        }

        $path = $this->path();

        if (count($parameters) > 0) {
            $path .= (str_contains($this->path(), "?") ? "&" : "?")
                .Arr::query($parameters)
                .$this->buildFragment();
        }

        return $path;
    }
}