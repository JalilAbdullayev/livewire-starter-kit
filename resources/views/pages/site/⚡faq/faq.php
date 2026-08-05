<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\RendersSitePage;
use App\Models\FaqItem;
use App\Models\SiteModule;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    use RendersSitePage;

    public SiteModule $siteModule;

    public function mount(): void
    {
        $this->siteModule = SiteModule::query()
            ->with('seoMeta')
            ->where('key', SiteModuleEnum::Faq)
            ->firstOrFail();

        $this->seoable = $this->siteModule;
    }

    #[Computed]
    public function items()
    {
        return FaqItem::query()
            ->published()
            ->orderBy('sort_order')
            ->get();
    }
};
