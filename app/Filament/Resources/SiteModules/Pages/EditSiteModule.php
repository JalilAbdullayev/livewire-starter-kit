<?php

namespace App\Filament\Resources\SiteModules\Pages;

use App\Filament\Resources\SiteModules\SiteModuleResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteModule extends EditRecord
{
    protected static string $resource = SiteModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
        ];
    }
}
