<?php

namespace App\Filament\Resources;

use App\Enums\PathWay;
use App\Filament\Resources\SpeechResource\Pages\CreateSpeech;
use App\Filament\Resources\SpeechResource\Pages\EditSpeech;
use App\Filament\Resources\SpeechResource\Pages\ListSpeeches;
use App\Models\Speech;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SpeechResource extends Resource
{
    protected static ?string $model = Speech::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Select::make('workshop_id')
                    ->relationship('workshop', 'title')
                    // ->orderByRaw('CAST(SUBSTRING_INDEX(title, " ", -1) AS UNSIGNED) ASC')->paginate(10)
                    ->required(),
                TextInput::make('length')
                    // ->required()
                    ->maxLength(255),
                // use enum for pathways
                Select::make('pathway')
                    ->required()
                    ->options(
                        collect(array_column(PathWay::cases(), 'value', 'value')),
                    ),

                // level
                TextInput::make('level')
                    ->numeric(),
                // ->required(),
                // ->searchable(),
                Textarea::make('objectives')
                    // ->required()
                    ->columnSpanFull(),
                Textarea::make('evaluator_notes')
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->relationship('speaker', 'name')
                    ->required()
                    ->searchable(),
                // ->numeric(),
                Select::make('evaluator_id')
                    ->relationship('evaluator', 'name')
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('length')
                    ->searchable(),
                TextColumn::make('pathway')
                    ->searchable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('workshop_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpeeches::route('/'),
            'create' => CreateSpeech::route('/create'),
            'edit' => EditSpeech::route('/{record}/edit'),
        ];
    }
}
