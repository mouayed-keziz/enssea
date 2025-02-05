<?php

namespace App\Filament\Professor\Resources;

use App\Filament\Professor\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use App\Filament\Professor\Navigation\Sidebar as NavigationSidebar;
use Filament\Tables\Columns\ImageColumn;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Articles';
    protected static ?string $modelLabel = 'Article';
    protected static ?string $pluralLabel = 'Articles';
    protected static ?string $recordTitleAttribute = 'recordTitle';

    protected static ?int $navigationSort = NavigationSidebar::ARTICLES['sort'];
    protected static ?string $navigationGroup = NavigationSidebar::ARTICLES['group'];

    protected static bool $isGloballySearchable = true;

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'content'];
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
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->columnSpan('full'),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->columnSpan('full')
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('generateSlug')
                                            ->label('Générer')
                                            ->icon('heroicon-m-arrow-path')
                                            ->action(function (Forms\Get $get, Forms\Set $set) {
                                                $set('slug', \Illuminate\Support\Str::slug($get('title')));
                                            })
                                    ),
                                Forms\Components\RichEditor::make('content')
                                    ->label('Contenu')
                                    ->required()
                                    ->columnSpan('full')
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
                            ->columnSpan(2),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                    ->label('Image')
                                    ->collection('image')
                                    ->image()
                                    ->imageEditor()
                                    ->downloadable()
                                    ->class('rounded-lg'),
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->placeholder("Sans image")
                    ->circular(),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
