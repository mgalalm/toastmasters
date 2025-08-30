<?php

namespace App\Filament\Resources;

use App\Enums\Role;
use App\Filament\Resources\WorkshopAssignmentResource\Pages\CreateWorkshopAssignment;
use App\Filament\Resources\WorkshopAssignmentResource\Pages\EditWorkshopAssignment;
use App\Filament\Resources\WorkshopAssignmentResource\Pages\ListWorkshopAssignments;
use App\Filament\Resources\WorkshopAssignmentResource\RelationManagers\WorkshopsRelationManager;
use App\Models\WorkshopAssignment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkshopAssignmentResource extends Resource
{
    protected static ?string $model = WorkshopAssignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('workshop_id')
                    ->relationship('workshop', 'title', fn ($query) => $query->orderByRaw('CAST(SUBSTRING_INDEX(title, " ", -1) AS UNSIGNED)'))
                    // ->searchable()
                    ->required(),

                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                // TextInput::make('user_id')
                //     ->numeric(),
                Select::make('role')
                    ->options(array_combine(
                        array_map(fn ($role) => $role->value, Role::cases()),
                        array_map(fn ($role) => ucfirst($role->value), Role::cases()),
                    ))
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('workshop_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('role')
                    ->searchable(),
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
            WorkshopsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkshopAssignments::route('/'),
            'create' => CreateWorkshopAssignment::route('/create'),
            'edit' => EditWorkshopAssignment::route('/{record}/edit'),
        ];
    }
}
