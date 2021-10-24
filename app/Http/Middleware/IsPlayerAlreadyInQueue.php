<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsPlayerAlreadyInQueue
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->isUserInSearchingQueue()){
            return $next($request);
        };
        return response()->json([
            "data"=>[
                "message"=>__("game.you_are_already_in_searching_queue")
            ]
        ],403);
    }

    public function isUserInSearchingQueue()
    {
        return DB::table("searching_user")->where("user_id", "=", Auth::user()->id)->first();
    }
}
