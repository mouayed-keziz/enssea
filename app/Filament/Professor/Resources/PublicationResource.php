<?php

namespace App\Filament\Professor\Resources;

use App\Enums\PublicationType;
use App\Filament\Professor\Resources\PublicationResource\Pages;
use App\Models\Publication;
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
use App\Filament\Professor\Navigation\Sidebar as NavigationSidebar;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Publications';
    protected static ?string $modelLabel = 'Publication';
    protected static ?string $pluralLabel = 'Publications';
    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = NavigationSidebar::PUBLICATION['sort'];
    protected static ?string $navigationGroup = NavigationSidebar::PUBLICATION['group'];

    protected static bool $isGloballySearchable = true;

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()) {
            return static::getModel()::where('professor_id', Auth::user()->id)->count();
        }
        return null;
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
                                Forms\Components\Select::make('type')
                                    ->label('Type')
                                    ->options([
                                        'book' => 'Livre',
                                        'research_paper' => 'Article de recherche',
                                    ])
                                    ->required(),
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
                            ])
                            ->columnSpan(['lg' => 2]),

                        Forms\Components\Section::make('Document PDF')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('pdf')
                                    ->collection('pdf')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->required(),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'book' => 'Livre',
                        'research_paper' => 'Article de recherche',
                    ]),
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
                Tables\Actions\Action::make('open_pdf')
                    ->label('Ouvrir PDF')
                    ->icon('heroicon-o-document')
                    ->url(fn(Publication $record): string => $record->getFirstMediaUrl('pdf'))
                    ->openUrlInNewTab(),
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
                                Infolists\Components\TextEntry::make('type')
                                    ->label('Type')
                                    ->badge(),
                                Infolists\Components\TextEntry::make('description')
                                    ->label('Description')
                                    ->markdown(),
                            ])
                            ->columnSpan(['lg' => 2]),

                        Infolists\Components\Section::make('Document')
                            ->schema([
                                Infolists\Components\TextEntry::make('pdf')
                                    ->label('')
                                    ->view('filament.infolists.components.pdf-viewer', [
                                        'collection' => 'pdf'
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
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'view' => Pages\ViewPublication::route('/{record}'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
