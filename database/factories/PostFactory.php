<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence();
        return [
            'image' => fake()->imageUrl(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title), // Converts the title into a URL-friendly slug [Example: "The quick brown fox jumps." → "the-quick-brown-fox-jumps"]
            'content' => fake()->paragraph(5),
            'category_id' => Category::inRandomOrder()->first()->id, // Picks a random category from the categories table and assigns its ID. inRandomOrder()->first() randomly selects one row.
            'user_id' => 1,
            'published_at' => fake()->optional()->dateTime(),
        ];
    }
}
