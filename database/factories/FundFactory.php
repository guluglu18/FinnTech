<?php

namespace Database\Factories;

use App\Models\FundCategory;
use App\Models\FundSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fund>
 */
class FundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fundCategory = FundCategory::inRandomOrder()->first();  //Dohvati nasumičan red iz FundCategory
        $fundSubCategory = FundSubCategory::inRandomOrder()->first();

        return [
            'name' => $this->faker->word,
            'fund_category_id' => $fundCategory->id,
            'fund_sub_category_id' => $fundSubCategory->id,
            'ISIN' => $this->faker->unique()->regexify('[A-Z0-9]{12}'), // Generiše nasumični 12-znakovni alfanumerički kod
            'WKN' => $this->faker->unique()->regexify('[A-Z0-9]{6}'), // Generiše nasumični 6-znakovni alfanumerički kod

        ];
    }
}
