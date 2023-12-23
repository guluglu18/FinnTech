<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\FundCategory;
use Illuminate\Http\Request;

class FundController extends Controller
{
    public function index() {
    
    $query = Fund::query();
  
    if (request()->has('search')) {
        $searchTerm = request()->input('search');
        $query->where('name', 'like', "$searchTerm")
            ->orWhere('ISIN', 'like', "%$searchTerm%")
            ->orWhere('WKN', 'like', "%$searchTerm%");
        $funds = $query->paginate(10);
        $fundCategories = FundCategory::all();
        
        //dd($searchTerm);

    } else {
        $funds = Fund::all();
        $funds = Fund::paginate(10);
        $fundCategories = FundCategory::all();
    }

        return view('welcome', compact('funds', 'fundCategories'));
    }
}
