<?php

namespace App\Filament\Professor\Resources;

use App\Filament\Professor\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use App\Core\Sidebar;
use App\Filament\Professor\Navigation\Sidebar as NavigationSidebar;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'Vidéos';
    protected static ?string $modelLabel = 'Vidéo';
    protected static ?string $pluralLabel = 'Vidéos';
    protected static ?string $recordTitleAttribute = 'recordTitle';

    protected static ?int $navigationSort = NavigationSidebar::VIDEO['sort'];
    protected static ?string $navigationGroup = NavigationSidebar::VIDEO['group'];

    protected static bool $isGloballySearchable = true;

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'url'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('professor_id', Auth::user()->id)->count();
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
                                Forms\Components\TextInput::make('url')
                                    ->label('URL de la vidéo')
                                    ->hint('Les miniatures des vidéos YouTube sont générées automatiquement')
                                    ->required()
                                    ->url()
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make("description")
                                    ->label("Description")
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
                            ])
                            ->columnSpan(['lg' => 2]),

                        Forms\Components\Section::make('Miniature')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                                    ->collection('thumbnail')
                                    ->image()
                                    ->imageEditor(),
                            ])
                            ->columnSpan(['lg' => 1]),
                    ])
                    ->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular()
                    ->size(60)
                    ->label('Miniature'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->label('Corbeille'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Voir'),
                Tables\Actions\EditAction::make()
                    ->label('Modifier'),
                Tables\Actions\DeleteAction::make()
                    ->label('Supprimer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Supprimer'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('Supprimer définitivement'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->label('Restaurer'),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Grid::make()
                    ->schema([
                        Infolists\Components\Section::make('Informations')
                            ->schema([
                                Infolists\Components\TextEntry::make('title')
                                    ->label('Titre'),
                                Infolists\Components\TextEntry::make('url')
                                    ->label('URL'),
                            ])
                            ->columnSpan(['lg' => 2]),

                        Infolists\Components\Section::make('Miniature')
                            ->schema([
                                Infolists\Components\ImageEntry::make('thumbnail')
                                    ->label('')
                                    ->extraImgAttributes([
                                        'style' => 'max-width: 100%; height: auto;'
                                    ]),
                            ])
                            ->columnSpan(['lg' => 1]),
                    ])
                    ->columns(3)
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('professor_id', Auth::id())
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'view' => Pages\ViewVideo::route('/{record}'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
