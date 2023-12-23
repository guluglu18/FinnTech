<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($user) {
            $funds = Fund::inRandomOrder()->limit(10)->get();
            $user->favoriteFunds()->attach($funds);
        });
    }
}
