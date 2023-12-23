<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundSubCategory extends Model
{
    use HasFactory;

    public function fundCategory() {
        return $this->belongsTo('App\Models\FundCategory');
    }
    public function funds(){
        return $this->hasMany('App\Models\Fund');
    }

    
}
