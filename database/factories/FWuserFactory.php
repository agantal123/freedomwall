<?php

namespace Database\Factories;

use App\Models\FWuser;
use Illuminate\Database\Eloquent\Factories\Factory;

class FWuserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FWuser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'username' => $this->faker->username,
            'password' => $this->faker->password,
        ];
    }
}
