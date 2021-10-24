<?php

namespace Tests\traits;

use Illuminate\Support\Facades\DB;

trait PreparingEnv
{
    public function addUsersToSearchingQueue($users){
        foreach ($users as $user){
            DB::table("searching_user")
                ->insert(["user_id"=>$user->id]);
        }

    }
}
