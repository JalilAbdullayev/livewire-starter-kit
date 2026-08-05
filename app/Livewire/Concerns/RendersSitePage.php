<?php

namespace App\Livewire\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

trait RendersSitePage
{
    public ?Model $seoable = null;

    public ?string $fallbackTitle = null;

    public ?string $fallbackDescription = null;

    public function render(): View
    {
        return $this->view()->layout('layouts::site', $this->siteLayoutData());
    }

    /**
     * @return array<string, mixed>
     */
    protected function siteLayoutData(): array
    {
        return [
            'seoable' => $this->seoable,
            'fallbackTitle' => $this->fallbackTitle,
            'fallbackDescription' => $this->fallbackDescription,
        ];
    }
}
