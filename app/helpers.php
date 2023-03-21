<?php

if (!function_exists("autoredirect")) {
    function autoredirect($defaultRoute = null) {
        if (request()->has("redirect")) {
            return redirect($request->get("redirect"));
        }

        $route = $defaultRoute === null ? "index" : $defaultRoute;
        return redirect()->route($route);
    }
}