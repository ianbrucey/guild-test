<?php

namespace Database\Factories;

use App\Models\Borrower;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BorrowerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Borrower::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first' => 'Test',
            'last' => 'Last',
            'email' => 'rand@yopmail.com',
            'borrower_type' => '1',
            'annual_salary' => '123455',
            'bank_account_value' => '124545',
        ];
    }
}
