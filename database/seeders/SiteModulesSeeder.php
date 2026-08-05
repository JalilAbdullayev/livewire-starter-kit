<?php

namespace Database\Seeders;

use App\Enums\SiteModuleEnum;
use App\Models\Page;
use App\Models\SiteModule;
use Illuminate\Database\Seeder;

class SiteModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SiteModuleEnum::cases() as $index => $module) {
            $siteModule = SiteModule::query()->updateOrCreate(
                ['key' => $module->value],
                [
                    'type' => $module->type()->value,
                    'label' => $module->label(),
                    'is_active' => false,
                    'sort_order' => ($index + 1) * 10,
                    'show_page' => false,
                    'show_cards' => false,
                ],
            );

            if ($module->hasPage()) {
                Page::query()->firstOrCreate(
                    ['site_module_id' => $siteModule->id],
                    [
                        'title' => $module->label(),
                        'slug' => $module->value,
                        'content' => null,
                    ],
                );
            }

            $siteModule->ensureSeoMeta();
        }
    }
}
