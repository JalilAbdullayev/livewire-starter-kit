<?php

namespace Database\Factories;

use App\Models\ServiceCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ServiceCard>
 */
class ServiceCardFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'image' => null,
            'excerpt' => fake()->sentence(12),
            'text' => fake()->paragraphs(3, true),
            'sort_order' => fake()->numberBetween(0, 20),
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => false,
        ]);
    }
}
