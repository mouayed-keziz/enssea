<?php

namespace App\Filament\Admin\Resources\SpecializationResource\Pages;

use App\Filament\Admin\Resources\SpecializationResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageSpecializationLevels extends ManageRelatedRecords
{
    protected static string $resource = SpecializationResource::class;

    protected static string $relationship = 'levels';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Levels';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du niveau')
                    ->description('Gérez les informations principales du niveau')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Section::make('Métadonnées')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Créé le')
                            ->content(fn(?\App\Models\Level $record): string => $record ? $record->created_at->format('d/m/Y H:i') : '-'),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Modifié le')
                            ->content(fn(?\App\Models\Level $record): string => $record ? $record->updated_at->format('d/m/Y H:i') : '-'),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('view')
                    ->label('Voir')
                    ->url(fn($record): string => "/admin/levels/{$record->id}")
                    ->icon('heroicon-o-external-link'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\Action::make('levels')
                    ->label('Aller aux niveaux')
                    ->url(fn($record): string => "/admin/levels/{$record->id}"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
