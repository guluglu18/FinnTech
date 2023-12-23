<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    public function fundCategory() {
        return $this->belongsTo('App\Models\FundCategory');
    }

    public function fundSubCategory()
    {
        return $this->belongsTo('App\Models\FundSubCategory');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }


}
