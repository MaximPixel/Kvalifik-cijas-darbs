<?php

if (!function_exists("autoredirect")) {
    function autoredirect($defaultUrl = null) {
        if (request()->has("redirect")) {
            return redirect(request()->get("redirect"));
        }

        if ($defaultUrl !== null) {
            return redirect($defaultUrl);
        }

        return redirect()->route("index");
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