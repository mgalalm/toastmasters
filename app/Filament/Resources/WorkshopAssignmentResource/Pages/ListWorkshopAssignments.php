<?php

namespace App\Filament\Resources\WorkshopAssignmentResource\Pages;

use App\Filament\Resources\WorkshopAssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkshopAssignments extends ListRecords
{
    protected static string $resource = WorkshopAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
