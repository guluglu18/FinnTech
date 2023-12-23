<?php

namespace Database\Factories;

use App\Models\FundCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FundSubCategory>
 */
class FundSubCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fundCategory = FundCategory::inRandomOrder()->first(); // Dohvati nasumičan red iz FundCategory

        return [
            'category_id' => $fundCategory->id,
            'name' => $this->faker->word,
        ];
    }
}
