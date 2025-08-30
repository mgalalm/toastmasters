<?php

namespace App\Filament\Resources\SpeechResource\Pages;

use App\Filament\Resources\SpeechResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSpeech extends EditRecord
{
    protected static string $resource = SpeechResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
