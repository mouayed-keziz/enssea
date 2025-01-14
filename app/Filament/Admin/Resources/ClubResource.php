<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Navigation\Sidebar;
use App\Filament\Admin\Resources\ClubResource\Pages;
use App\Filament\Admin\Resources\ClubResource\RelationManagers;
use App\Models\Club;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Clubs';
    protected static ?string $modelLabel = 'Club';
    protected static ?string $pluralLabel = 'Clubs';
    protected static ?string $recordTitleAttribute = 'recordTitle';

    protected static ?int $navigationSort = Sidebar::CLUB['sort'];
    protected static ?string $navigationGroup = Sidebar::CLUB['group'];

    protected static bool $isGloballySearchable = true;
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description']; // Add columns you want to search
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
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->nullable(),
                                Forms\Components\TextInput::make('website_url')
                                    ->label('Site Web')
                                    ->url()
                                    ->nullable(),
                                Forms\Components\KeyValue::make('social_media_links')
                                    ->label('Liens des Réseaux Sociaux')
                                    ->keyLabel('Plateforme')
                                    ->valueLabel('Lien')
                                    ->nullable(),
                            ])
                            ->columnSpan(3),

                        Forms\Components\Section::make('Logo du Club')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('club_logo')
                                    ->label('Logo')
                                    ->collection('club_logo')
                                    ->image()
                                    ->imageEditor(),
                            ])
                            ->columnSpan(2),
                    ])
                    ->columns(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->placeholder("Sans logo")
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                TextColumn::make('website_url')
                    ->label('Site Web')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Non supprimé')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->button(),
                Tables\Actions\EditAction::make()->button()->outlined(),
                Tables\Actions\ForceDeleteAction::make()->button()->outlined(),
                Tables\Actions\RestoreAction::make()->button()->outlined(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make()
                    ->schema([

                        Section::make('Informations')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nom'),
                                TextEntry::make('description')
                                    ->label('Description'),
                                TextEntry::make('website_url')
                                    ->label('Site Web'),
                                TextEntry::make('social_media_links')
                                    ->label('Liens des Réseaux Sociaux')
                                    ->formatStateUsing(function ($state) {
                                        return collect($state)->map(function ($url, $platform) {
                                            return "$platform: $url";
                                        })->implode("\n");
                                    }),
                            ])
                            ->columnSpan(3),

                        Section::make('Logo du Club')
                            ->schema([
                                SpatieMediaLibraryImageEntry::make('club_logo')
                                    ->collection('club_logo')
                                    ->label('')
                                    ->extraImgAttributes(
                                        ['style' => 'max-width: 100%; height: auto;']
                                    )
                            ])
                            ->columnSpan(2),
                    ])
                    ->columns(5),
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
            'index' => Pages\ListClubs::route('/'),
            'create' => Pages\CreateClub::route('/create'),
            'view' => Pages\ViewClub::route('/{record}'),
            'edit' => Pages\EditClub::route('/{record}/edit'),
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
