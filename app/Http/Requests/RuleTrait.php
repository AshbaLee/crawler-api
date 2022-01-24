<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

trait RuleTrait
{
    public function rule()
    {
        $action = Route::getCurrentRoute()->action ?? null;

        if ($action) {
            $controller = $action['controller'];
            $actionName = Str::after($controller, '@');

            if (method_exists($this, $actionName)) {
                return $this->$actionName();
            }
        }

        return [];
    }
}
