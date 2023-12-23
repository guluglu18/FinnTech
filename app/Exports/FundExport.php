<?php

namespace App\Exports;

use App\Models\Fund;
use Maatwebsite\Excel\Concerns\FromCollection;

class FundExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Fund::all();
    }
}
