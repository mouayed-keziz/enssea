<?php

namespace App\Filament\Professor\Resources;

use App\Filament\Admin\Navigation\Sidebar;
use App\Filament\Professor\Resources\ProfessorResource\Pages;
use App\Models\Professor;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Constants\Countries;

class ProfessorResource extends Resource
{
    protected static ?string $model = Professor::class;
    protected static bool $shouldRegisterNavigation = false; // Hide from menu

    public static function getSlug(): string
    {
        return '_';
    }

    public static function getPages(): array
    {
        return [
            'edit' => Pages\EditProfessor::route('/edit-profile/{record}'),
        ];
    }

    // protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    // protected static ?string $navigationLabel = 'Professeurs';
    // protected static ?string $modelLabel = 'Professeur';
    // protected static ?string $pluralLabel = 'Professeurs';
    // protected static ?string $recordTitleAttribute = 'recordTitle';

    // protected static ?int $navigationSort = Sidebar::PROFESSOR['sort'];
    // protected static ?string $navigationGroup = Sidebar::PROFESSOR['group'];

    // protected static bool $isGloballySearchable = true;
    // public static function getGloballySearchableAttributes(): array
    // {
    //     return ['name', 'email', 'bio'];
    // }

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Onglets')
                    ->persistTabInQueryString()
                    ->tabs([
                        Tabs\Tab::make('Informations Personnelles')
                            ->schema([
                                Section::make('Informations Personnelles')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nom')
                                                    ->required()
                                                    ->columnSpan(['md' => 2]),
                                                TextInput::make('email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->required()
                                                    ->columnSpan(['md' => 2]),
                                                TextInput::make('password')
                                                    ->label('Password')
                                                    ->password()
                                                    ->visibleOn("create")
                                                    ->required()
                                                    ->columnSpan(['md' => 4]),
                                            ])
                                            ->columns(4),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Textarea::make('bio')
                                                    ->label('Biographie')
                                                    ->nullable()
                                                    ->rows(5)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(4),

                                        SpatieMediaLibraryFileUpload::make('profile_picture')
                                            ->label('Photo de profil')
                                            ->collection('profile_picture') // Use the Spatie media collection
                                            ->image()
                                            ->imageEditor()
                                            ->nullable()
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                            ]),

                        Tabs\Tab::make('Réseaux Sociaux')
                            ->schema([
                                Section::make('Réseaux Sociaux')
                                    ->schema([
                                        KeyValue::make('social_media')
                                            ->label('Liens des Réseaux Sociaux')
                                            ->keyLabel('Plateforme')
                                            ->valueLabel('Lien')
                                            ->nullable(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Éducation')
                            ->schema([
                                Section::make('Éducation')
                                    ->schema([
                                        Repeater::make('education')
                                            ->label('Éducation')
                                            ->schema([
                                                TextInput::make('time')
                                                    ->label('Période')
                                                    ->required(),
                                                TextInput::make('title')
                                                    ->label('Titre')
                                                    ->required(),
                                                TextInput::make('description')
                                                    ->label('Description')
                                                    ->required(),
                                            ])
                                            ->nullable(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Expérience')
                            ->schema([
                                Section::make('Expérience')
                                    ->schema([
                                        Repeater::make('experience')
                                            ->label('Expérience')
                                            ->schema([
                                                TextInput::make('time')
                                                    ->label('Période')
                                                    ->required(),
                                                TextInput::make('title')
                                                    ->label('Titre')
                                                    ->required(),
                                                TextInput::make('description')
                                                    ->label('Description')
                                                    ->required(),
                                            ])
                                            ->nullable(),
                                    ]),
                            ]),

                        Tabs\Tab::make('Compétences')
                            ->schema([
                                Section::make('Compétences')
                                    ->schema([
                                        Repeater::make('skills')
                                            ->label('Compétences')
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nom de la compétence')
                                                    ->required(),
                                                TextInput::make('level')
                                                    ->label('Niveau de compétence (0-100)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->required(),
                                            ])
                                            ->nullable(),
                                    ]),
                            ]),

                        Tabs\Tab::make('CV')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('cv')
                                    ->label('')
                                    ->collection('cv')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->nullable(),
                                Forms\Components\View::make('filament.infolists.components.pdf-viewer')
                                    ->viewData([
                                        'collection' => 'cv'
                                    ]),
                            ]),

                        Tabs\Tab::make('Activités')
                            ->schema([
                                Section::make('Activités')
                                    ->schema([
                                        Repeater::make('activities')
                                            ->label('')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Titre')
                                                    ->required(),
                                                Forms\Components\Select::make('country')
                                                    ->searchable()
                                                    ->options(Countries::COUNTRIES)
                                                    ->label('Pays concerné')
                                                    ->required(),
                                                Forms\Components\RichEditor::make('description')
                                                    ->label('Description')
                                                    ->required()
                                                    ->columnSpanFull(),
                                            ])
                                            ->collapsible()
                                            ->collapseAllAction(
                                                fn(\Filament\Forms\Components\Actions\Action $action) => $action->label('Réduire tout'),
                                            )
                                            ->expandAllAction(
                                                fn(\Filament\Forms\Components\Actions\Action $action) => $action->label('Développer tout'),
                                            )
                                            ->nullable(),
                                    ]),
                            ]),

                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_picture')
                    ->label('Photo de profil')
                    ->circular()
                    ->placeholder('Pas d\'image'), // Handle empty state
                TextColumn::make('name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),
            ])
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
}
