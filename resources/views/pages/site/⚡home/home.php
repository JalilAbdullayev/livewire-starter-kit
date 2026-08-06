<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\RendersSitePage;
use App\Models\BlogPost;
use App\Models\ServiceCard;
use App\Models\SiteModule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Home')] class extends Component
{
    use RendersSitePage;

    public function mount(): void
    {
        $this->fallbackTitle = config('app.name');
        $this->fallbackDescription = __('A modular TALL stack starter kit for landing pages, portfolios, and more.');
    }

    /**
     * @return array{label: string, href: string}|null
     */
    #[Computed]
    public function primaryAction(): ?array
    {
        if (SiteModule::isActive(SiteModuleEnum::Contact)) {
            return [
                'label' => __('Get in touch'),
                'href' => localized_route('site.contact'),
            ];
        }

        $firstModule = $this->activeModules->first();

        if ($firstModule === null) {
            return null;
        }

        return [
            'label' => $firstModule->label,
            'href' => localized_route($firstModule->key->routeName()),
        ];
    }

    #[Computed]
    public function activeModules()
    {
        return SiteModule::query()
            ->with('page')
            ->active()
            ->orderBy('sort_order')
            ->get();
    }

    #[Computed]
    public function latestPosts()
    {
        if (! SiteModule::isActive(SiteModuleEnum::Blog)) {
            return collect();
        }

        return BlogPost::query()
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();
    }

    #[Computed]
    public function featuredServiceCards()
    {
        $servicesModule = SiteModule::findByKey(SiteModuleEnum::Services);

        if ($servicesModule === null || ! $servicesModule->is_active || ! $servicesModule->show_cards) {
            return collect();
        }

        return ServiceCard::query()
            ->published()
            ->orderBy('sort_order')
            ->limit(3)
            ->get();
    }
};
