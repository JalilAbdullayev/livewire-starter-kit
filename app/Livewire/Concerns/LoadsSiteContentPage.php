<?php

namespace App\Livewire\Concerns;

use App\Enums\SiteModuleEnum;
use App\Models\Page;
use App\Models\SiteModule;

trait LoadsSiteContentPage
{
    public SiteModule $siteModule;

    public ?Page $page = null;

    protected function loadSiteContentPage(SiteModuleEnum $module): void
    {
        $this->siteModule = SiteModule::query()
            ->with(['page.seoMeta'])
            ->where('key', $module)
            ->firstOrFail();

        $this->page = $this->siteModule->page;
        $this->seoable = $this->page;
    }
}
