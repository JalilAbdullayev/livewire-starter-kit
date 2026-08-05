<?php

use App\Enums\SiteModuleEnum;
use App\Models\BlogPost;
use App\Models\FaqItem;
use App\Models\SiteModule;
use Database\Seeders\SiteModulesSeeder;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);
});

test('blog shows published posts when module is active', function () {
    SiteModule::query()->where('key', SiteModuleEnum::Blog)->update(['is_active' => true]);

    BlogPost::factory()->create(['title' => 'Hello World', 'is_published' => true]);
    BlogPost::factory()->unpublished()->create(['title' => 'Draft Post']);

    $this->get(route('site.blog.index'))
        ->assertOk()
        ->assertSee('Hello World')
        ->assertDontSee('Draft Post');
});

test('faq lists published questions and answers', function () {
    SiteModule::query()->where('key', SiteModuleEnum::Faq)->update(['is_active' => true]);

    FaqItem::factory()->create([
        'question' => 'What is this?',
        'answer' => 'A starter kit.',
        'is_published' => true,
    ]);

    $this->get(route('site.faq'))
        ->assertOk()
        ->assertSee('What is this?')
        ->assertSee('A starter kit.');
});
