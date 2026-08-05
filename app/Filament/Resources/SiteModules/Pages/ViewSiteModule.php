<?php

namespace App\Filament\Resources\SiteModules\Pages;

use App\Filament\Resources\SiteModules\SiteModuleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSiteModule extends ViewRecord
{
    protected static string $resource = SiteModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
