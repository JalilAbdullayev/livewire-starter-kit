<?php

namespace App\Filament\Resources\ServiceCards\Pages;

use App\Filament\Resources\ServiceCards\ServiceCardResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewServiceCard extends ViewRecord
{
    protected static string $resource = ServiceCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
