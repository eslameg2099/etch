<?php

namespace Database\Factories;

use App\Models\UserCredit;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserCredit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'account_name' => $this->faker->name,
            'bank_name' => $this->faker->word,
            'account_number' => $this->faker->bankAccountNumber,
            'iban_number' => $this->faker->iban('SA'),
            'remember' => $this->faker->boolean,
        ];
    }
}
