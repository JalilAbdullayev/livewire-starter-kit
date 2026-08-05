<?php

use App\Enums\SiteModuleEnum;
use App\Models\ContactMessage;
use App\Models\SiteModule;
use Database\Seeders\SiteModulesSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(SiteModulesSeeder::class);

    SiteModule::query()
        ->where('key', SiteModuleEnum::Contact)
        ->update(['is_active' => true]);
});

test('contact form stores name email phone subject and message', function () {
    Livewire::test('pages::site.contact')
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('phone', '+994501234567')
        ->set('subject', 'Hello')
        ->set('message', 'I need help with my project.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    $this->assertDatabaseHas(ContactMessage::class, [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+994501234567',
        'subject' => 'Hello',
        'message' => 'I need help with my project.',
    ]);
});
