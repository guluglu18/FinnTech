<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFund extends Model
{
    protected $fillable = ['user_id', 'fund_id',];


    use HasFactory;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function fund(){
        return $this->belongsTo('App\Models\Fund');
    }
}
