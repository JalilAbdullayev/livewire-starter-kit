<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\RendersSitePage;
use App\Models\BlogPost;
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
            ->where('key', SiteModuleEnum::Blog)
            ->firstOrFail();

        $this->seoable = $this->siteModule;
    }

    #[Computed]
    public function posts()
    {
        return BlogPost::query()
            ->published()
            ->latest('published_at')
            ->paginate(10);
    }
};
