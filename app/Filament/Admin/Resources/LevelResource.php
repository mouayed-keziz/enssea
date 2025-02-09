<?php

namespace App\Filament\Admin\Resources;

use App\Enums\LevelCycle;
use App\Filament\Admin\Resources\LevelResource\Pages;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Niveaux';
    protected static ?string $modelLabel = 'Niveau';
    protected static ?string $pluralLabel = 'Niveaux';
    protected static ?string $recordTitleAttribute = 'name';

    protected static bool $isGloballySearchable = true;

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'cycle'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du niveau')
                    ->description('Gérez les informations principales du niveau')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required(),
                        Forms\Components\Select::make('cycle')
                            ->label('Cycle')
                            ->options(LevelCycle::class)
                            ->required(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Métadonnées')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Créé le')
                            ->content(fn (?Level $record): string => $record ? $record->created_at->format('d/m/Y H:i') : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modifié le')
                            ->content(fn (?Level $record): string => $record ? $record->updated_at->format('d/m/Y H:i') : '-'),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cycle')
                    ->label('Cycle')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Voir'),
                Tables\Actions\EditAction::make()->label('Modifier'),
                Tables\Actions\Action::make('subjects')
                    ->label('Matières')
                    ->icon('heroicon-o-book-open')
                    ->url(fn ($record) => "/admin/levels/{$record->id}/subjects")
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [



        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'view' => Pages\ViewLevel::route('/{record}'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
            'subjects' => Pages\ManageLevelSubjects::route('/{record}/subjects'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}



