<?php

namespace App\Filament\Resources\WorkshopAssignmentResource\Pages;

use App\Filament\Resources\WorkshopAssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkshopAssignment extends EditRecord
{
    protected static string $resource = WorkshopAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
