<?php

use App\Enums\SiteModuleEnum;
use App\Livewire\Concerns\RendersSitePage;
use App\Models\ServiceCard;
use App\Models\SiteModule;
use Livewire\Component;

new class extends Component
{
    use RendersSitePage;

    public SiteModule $siteModule;

    public ServiceCard $card;

    public function mount(string $slug): void
    {
        $this->siteModule = SiteModule::findByKey(SiteModuleEnum::Services);

        if ($this->siteModule === null || ! $this->siteModule->show_cards) {
            abort(404);
        }

        $this->card = ServiceCard::query()
            ->with('seoMeta')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $this->seoable = $this->card;
        $this->fallbackTitle = $this->card->title;
        $this->fallbackDescription = $this->card->excerpt;
    }
};
