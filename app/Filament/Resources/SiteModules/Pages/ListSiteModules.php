<?php

namespace App\Filament\Resources\SiteModules\Pages;

use App\Filament\Resources\SiteModules\SiteModuleResource;
use Filament\Resources\Pages\ListRecords;

class ListSiteModules extends ListRecords
{
    protected static string $resource = SiteModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
