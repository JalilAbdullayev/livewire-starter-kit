<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\LoadsSiteContentPage;
use App\Livewire\Concerns\RendersSitePage;
use Livewire\Component;

new class extends Component
{
    use LoadsSiteContentPage;
    use RendersSitePage;

    public function mount(): void
    {
        $this->loadSiteContentPage(SiteModuleEnum::Privacy);
    }
};
