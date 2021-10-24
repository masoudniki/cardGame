<?php

namespace App\Http\Controllers;

use App\Http\Middleware\IsEventFromPusher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(IsEventFromPusher::class);
    }
    public function __invoke(Request $request){
        $this->validate($request,[
            "event"=>"required|string"
        ]);
        $eventName=$request->get("event");
        if(method_exists($this,$eventName) && $eventName!="__invoke"){
            call_user_func([$this,$eventName],$request);
        }
        return response()->json("ok",200);
    }


}
