<?php

namespace Database\Seeders;

use App\Models\FundCategory;
use App\Models\FundSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories=FundCategory::all();
        $subCategories=FundSubCategory::all();
        \App\Models\Fund::factory(1000)->create()->each(function($fund) use ($categories, $subCategories){
            $randomCategory = $categories->random();
            $randomSubCategory = $subCategories->random();

            $fund->update([
                'fund_category_id' => $randomCategory->id,
                'fund_sub_category_id' => $randomSubCategory->id,
            ]);
        });
    }
}
