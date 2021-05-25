<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\FWuser;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'title' => $this->faker->title,
        'description' => $this->faker->paragraph,
        'user_id' => App\FWuser::inRandomOrder()->first()->id,
        ];
    }
}
