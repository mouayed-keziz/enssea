<?php

namespace App\Filament\Resources;

use App\Filament\Navigation\Sidebar;
use App\Filament\Resources\SponsorResource\Pages;
use App\Filament\Resources\SponsorResource\RelationManagers;
use App\Models\Sponsor;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Sponsors et Conventions';
    protected static ?string $modelLabel = 'Sponsor / Convention';
    protected static ?string $pluralLabel = 'Sponsors et Conventions';
    protected static ?string $recordTitleAttribute = 'recordTitle';

    protected static ?int $navigationSort = Sidebar::SPONSOR['sort'];
    protected static ?string $navigationGroup = Sidebar::SPONSOR['group'];

    protected static bool $isGloballySearchable = true;
    public static function getGloballySearchableAttributes(): array
    {
        return ['name']; // Add columns you want to search
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        // First Section (3/5 width)
                        Forms\Components\Section::make('Informations')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Description')
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ]),
                                Forms\Components\TextInput::make('url')
                                    ->label('Site Web')
                                    ->url()
                                    ->nullable(),
                            ])
                            ->columnSpan(3), // 3/5 width

                        // Second Section (2/5 width)
                        Forms\Components\Section::make('Logo du Sponsor')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('sponsor_logo')
                                    ->label('Logo')
                                    ->collection('sponsor_logo')
                                    ->image()
                                    ->imageEditor(),
                            ])
                            ->columnSpan(2), // 2/5 width
                    ])
                    ->columns(5), // Total of 5 columns
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('sponsor_logo')
                    ->label('Logo')
                    ->collection('sponsor_logo')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('url')
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
                        // First Section (3/5 width)
                        Section::make('Informations')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nom'),
                                TextEntry::make('url')
                                    ->label('Site Web'),
                                TextEntry::make('description')
                                    ->markdown()
                                    ->label('Description'),
                            ])
                            ->columnSpan(3), // 3/5 width

                        // Second Section (2/5 width)
                        Section::make('Logo du Sponsor')
                            ->schema([
                                SpatieMediaLibraryImageEntry::make('sponsor_logo')
                                    ->collection('sponsor_logo')
                                    ->label('')
                                    ->extraImgAttributes(
                                        ['style' => 'max-width: 100%; height: auto;']
                                    ),
                            ])
                            ->columnSpan(2), // 2/5 width
                    ])
                    ->columns(5), // Total of 5 columns
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
            'index' => Pages\ListSponsors::route('/'),
            'create' => Pages\CreateSponsor::route('/create'),
            'view' => Pages\ViewSponsor::route('/{record}'),
            'edit' => Pages\EditSponsor::route('/{record}/edit'),
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
