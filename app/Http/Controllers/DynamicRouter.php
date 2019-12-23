<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Registry;
use App\Commodity;
use Illuminate\Support\Facades\Route;

class DynamicRouter extends Controller
{
    public function handle(Request $request)
    {         

        $registry = Registry::query()
            ->with('entry')
            ->where('url', '=', $request->path())
            ->firstOrFail();            

        if ($registry->redirect) {
            return redirect()->to($registry->destination, $registry->code);
        } else {
            list($class, $method) = explode('@', $registry->destination);
            $controller           = app()->make("App\\Http\\Controllers\\" . $class);            

            if ($request->isMethod('post') && ! is_null($registry->request)) {
                $request = app("App\\Http\\Requests\\" . $registry->request);
            }

            return $controller->callAction(($request->isMethod('post') ? 'do_' : '') . $method, [
                $request,
                $registry,
                $registry->entry,
            ]);
        }
    }
}
