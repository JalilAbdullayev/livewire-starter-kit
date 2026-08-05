<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\RendersSitePage;
use App\Models\Page;
use App\Models\ServiceCard;
use App\Models\SiteModule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use RendersSitePage;

    public SiteModule $siteModule;

    public ?Page $page = null;

    public function mount(): void
    {
        $this->siteModule = SiteModule::query()
            ->with(['page', 'seoMeta'])
            ->where('key', SiteModuleEnum::Services)
            ->firstOrFail();

        $this->page = $this->siteModule->page;
        $this->seoable = $this->siteModule;
    }

    #[Computed]
    public function cards()
    {
        if (! $this->siteModule->show_cards) {
            return collect();
        }

        return ServiceCard::query()->published()->orderBy('sort_order')->get();
    }
};
