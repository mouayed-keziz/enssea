<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Navigation\Sidebar;
use App\Filament\Admin\Resources\SpecializationResource\Pages;
use App\Filament\Admin\Resources\SpecializationResource\RelationManagers;
use App\Filament\Admin\Resources\SpecializationResource\RelationManagers\LevelsRelationManager;
use App\Models\Specialization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecializationResource extends Resource
{
    protected static ?string $model = Specialization::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Spécialisations';
    protected static ?string $modelLabel = 'Spécialisation';
    protected static ?string $pluralLabel = 'Spécialisations';
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = Sidebar::SPECIALIZATION['sort'];
    protected static ?string $navigationGroup = Sidebar::SPECIALIZATION['group'];

    protected static bool $isGloballySearchable = true;
    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make('Informations')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                    ->label('Image')
                                    ->collection('image')
                                    ->image()
                                    ->imageEditor(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->placeholder('Aucune image'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('levels')
                    ->label('Niveaux')
                    ->url(fn($record): string => "/admin/specializations/{$record->id}/levels"),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecializations::route('/'),
            'create' => Pages\CreateSpecialization::route('/create'),
            'view' => Pages\ViewSpecialization::route('/{record}'),
            'edit' => Pages\EditSpecialization::route('/{record}/edit'),
            "levels" => Pages\ManageSpecializationLevels::route('/{record}/levels'),
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
