<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchingUser extends Model
{
    use HasFactory;
    protected $table="searching_user";
    protected $fillable=[
        "user_id"
    ];
    public function users(){
        return $this->belongsTo(User::class,"user_id","id");
    }
}
