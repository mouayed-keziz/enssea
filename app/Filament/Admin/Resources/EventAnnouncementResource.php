<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Navigation\Sidebar;
use App\Filament\Admin\Resources\EventAnnouncementResource\Pages;
use App\Models\EventAnnouncement;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventAnnouncementResource extends Resource
{
    protected static ?string $model = EventAnnouncement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Évènements';
    protected static ?string $modelLabel = 'Évènement';
    protected static ?string $pluralLabel = 'Évènements';

    protected static ?string $recordTitleAttribute = 'recordTitle';

    protected static ?int $navigationSort = Sidebar::EVENT_ANNOUNCEMENT['sort'];
    protected static ?string $navigationGroup = Sidebar::EVENT_ANNOUNCEMENT['group'];

    protected static bool $isGloballySearchable = true;
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'location']; // Add columns you want to search
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
                                Forms\Components\TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->label('Description')
                                    ->rows(4)
                                    ->maxLength(65535),
                                Forms\Components\TextInput::make('location')
                                    ->label('Lieu')
                                    ->maxLength(255),
                                Forms\Components\DateTimePicker::make('date')
                                    ->label('Date')
                                    ->native(false)
                                    ->displayFormat('d/m/Y H:i')
                                    ->required(),
                                Forms\Components\RichEditor::make('content')
                                    ->label('Contenu')
                                    ->toolbarButtons([
                                        'bold',
                                        'bulletList',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'undo',
                                    ])
                            ])
                            ->columnSpan(3),

                        Forms\Components\Section::make('Image')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('image')
                                    ->label('')
                                    ->collection('image')
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
                ImageColumn::make('image')
                    ->placeholder("Aucune image")
                    ->label('Image')
                    ->circular(),
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('location')
                    ->label('Lieu')
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('Non supprimé')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'desc')
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
                                TextEntry::make('title')
                                    ->label('Titre'),
                                TextEntry::make('description')
                                    ->label('Description'),
                                TextEntry::make('location')
                                    ->label('Lieu'),
                                TextEntry::make('date')
                                    ->label('Date')
                                    ->dateTime('d/m/Y H:i'),
                                TextEntry::make('content')
                                    ->label('Contenu')
                                    ->html(),
                            ])
                            ->columnSpan(3),

                        Section::make('Image')
                            ->schema([
                                SpatieMediaLibraryImageEntry::make('image')
                                    ->label('')
                                    ->placeholder("Aucune image")
                                    ->collection('image')
                                    ->extraImgAttributes([
                                        'style' => 'max-width: 100%; height: auto;'
                                    ])
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
            'index' => Pages\ListEventAnnouncements::route('/'),
            'create' => Pages\CreateEventAnnouncement::route('/create'),
            'view' => Pages\ViewEventAnnouncement::route('/{record}'),
            'edit' => Pages\EditEventAnnouncement::route('/{record}/edit'),
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
