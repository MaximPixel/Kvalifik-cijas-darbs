<?php

if (!function_exists("autoredirect")) {
    function autoredirect($defaultRoute = null) {
        if (request()->has("redirect")) {
            return redirect(request()->get("redirect"));
        }

        $route = $defaultRoute === null ? "index" : $defaultRoute;
        return redirect()->route($route);
    }
}

if (!function_exists("mergeparams")) {
    function mergeparams(array $param1, array $param2 = null) {
        if ($param2 === null) {
            return $param1;
        }

        return collect($param1)->merge($param2)->toArray();
    }
}