<?php

namespace App\Filament\Admin\Resources\LevelResource\Pages;

use App\Filament\Admin\Resources\LevelResource;
use App\Enums\SubjectSemester;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManageLevelSubjects extends ManageRelatedRecords
{
    protected static string $resource = LevelResource::class;
    protected static string $relationship = 'subjects';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $title = 'Modules';

    public static function getNavigationLabel(): string
    {
        return 'Modules';
    }



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Information du module')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('subject_semester')
                            ->label('Semestre')
                            ->options(SubjectSemester::class)
                            ->required(),
                        Forms\Components\Select::make('professor_id')
                            ->label('Professeur')
                            ->relationship('professor', 'name')
                            ->required()
                            ->native(false)
                            ->searchable(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Section::make('Image')
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                            ->label('Image de la modules')
                            ->image()
                            ->collection('image')
                    ])
                    ->columnSpan(['lg' => 1])
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject_semester')
                    ->label('Semestre'),
                Tables\Columns\TextColumn::make('professor.name')
                    ->label('Professeur'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->label('Image')
                    ->collection('image'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
                    ->label('Archivés'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Nouveau module'),
                // Tables\Actions\AssociateAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('Retour aux niveaux')
                    ->color("gray")
                    ->url(fn () => "/admin/levels/".$this->record->id),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Voir'),
                Tables\Actions\EditAction::make()->label('Modifier'),
                // Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make()->label('Supprimer'),
                Tables\Actions\ForceDeleteAction::make()->label('Supprimer définitivement'),
                Tables\Actions\RestoreAction::make()->label('Restaurer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Supprimer la sélection'),
                    Tables\Actions\RestoreBulkAction::make()->label('Restaurer la sélection'),
                    Tables\Actions\ForceDeleteBulkAction::make()->label('Supprimer définitivement la sélection'),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }


}
