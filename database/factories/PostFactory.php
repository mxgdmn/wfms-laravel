<?php

namespace Database\Factories;

use App\Models\Post;
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
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(3, true),
            'content' => $this->faker->paragraphs(3, true),
            'views' => $this->faker->numberBetween(1,20),
            'thumbnail' => 'img/2021-09-21/bi4FohNxa0tsFVg5m6rbXBc2zA0NOYKJCQbGB4kS.png',
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
            'category_id' => $this->faker->numberBetween(1,3),
        ];
    }
}
