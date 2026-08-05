<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(4, true),
            'is_published' => true,
            'published_at' => now(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
