<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function unauthenticated($request, array $guards)
    {
        abort(response()->json(
            [
                "data"=>[
                    "message"=>__("auth.unauthenticated")
                ]
            ]
        ,401));
    }
}
