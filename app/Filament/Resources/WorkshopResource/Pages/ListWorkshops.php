<?php

namespace App\Filament\Resources\WorkshopResource\Pages;

use App\Filament\Resources\WorkshopResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkshops extends ListRecords
{
    protected static string $resource = WorkshopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
