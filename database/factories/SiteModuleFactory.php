<?php

namespace Database\Factories;

use App\Enums\SiteModuleEnum;
use App\Models\SiteModule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteModule>
 */
class SiteModuleFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $module = fake()->randomElement(SiteModuleEnum::cases());

        return [
            'key' => $module,
            'type' => $module->type(),
            'label' => $module->label(),
            'is_active' => false,
            'sort_order' => 0,
            'show_page' => false,
            'show_cards' => false,
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_active' => true,
        ]);
    }

    public function forModule(SiteModuleEnum $module): static
    {
        return $this->state(fn (array $attributes): array => [
            'key' => $module,
            'type' => $module->type(),
            'label' => $module->label(),
        ]);
    }
}
