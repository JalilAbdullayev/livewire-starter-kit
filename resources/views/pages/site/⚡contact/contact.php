<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\LoadsSiteContentPage;
use App\Livewire\Concerns\RendersSitePage;
use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    use LoadsSiteContentPage;
    use RendersSitePage;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|max:50')]
    public string $phone = '';

    #[Validate('required|string|max:255')]
    public string $subject = '';

    #[Validate('required|string|max:5000')]
    public string $message = '';

    public bool $submitted = false;

    public function mount(): void
    {
        $this->loadSiteContentPage(SiteModuleEnum::Contact);
    }

    public function submit(): void
    {
        $data = $this->validate();

        ContactMessage::query()->create($data);

        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
        $this->submitted = true;
    }
};
