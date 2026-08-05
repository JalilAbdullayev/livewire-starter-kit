<?php

namespace App\Filament\Resources\ServiceCards\Pages;

use App\Filament\Resources\ServiceCards\ServiceCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListServiceCards extends ListRecords
{
    protected static string $resource = ServiceCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
