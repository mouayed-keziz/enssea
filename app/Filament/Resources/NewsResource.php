<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Contenu du Site';
    protected static ?string $modelLabel = 'Actualité';
    protected static ?string $pluralLabel = 'Actualités';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        // First Section (3/5 width)
                        Forms\Components\Section::make('Informations')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('content')
                                    ->label('Contenu')
                                    ->required()
                                    ->maxLength(65535),
                                Forms\Components\DatePicker::make('date')
                                    ->label('Date')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->nullable(),
                            ])
                            ->columnSpan(3), // 3/5 width

                        // Second Section (2/5 width)
                        Forms\Components\Section::make('Image de Couverture')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('news_cover')
                                    ->label('Image de Couverture')
                                    ->collection('news_cover')
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
                ImageColumn::make('coverImage')
                    ->label('Image')
                    ->placeholder("Sans image")
                    ->circular(),
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('content')
                    ->label('Contenu')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                TextColumn::make('date')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime('d/m/Y H:i')
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
                        // First Section (3/5 width)
                        Section::make('Informations')
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Titre'),
                                TextEntry::make('content')
                                    ->label('Contenu'),
                                TextEntry::make('date')
                                    ->label('Date')
                                    ->date('d/m/Y'),
                            ])
                            ->columnSpan(3), // 3/5 width

                        // Second Section (2/5 width)
                        Section::make('Image de Couverture')
                            ->schema([
                                ImageEntry::make('news_cover')
                                    ->label('Image de Couverture')
                                    ->circular(),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'view' => Pages\ViewNews::route('/{record}'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
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
