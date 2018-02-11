<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authorize as LaravelAuthorize;
use Illuminate\Http\Request;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Authorize extends LaravelAuthorize
{
    protected function getModel($request, $model)
    {
        return $this->isClassName($model) ? $model : $this->getRouteModel($request, $model);
    }

    private function getRouteModel(Request $request, string $model)
    {
        $bindings = $request->route('bindings') ? $request->route('bindings') : [];
        $bindings = collect($bindings);

        if ($bindings->has($model)) {
            return $bindings->get($model)::{'findOrFail'}($request->route($model));
        }

        return $request->route($model);
    }
}
