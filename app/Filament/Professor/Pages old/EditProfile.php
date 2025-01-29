<?php

namespace App\Filament\Professor\Pages;

use App\Models\Professor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Page
{
    use InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Mon Profil';
    protected static ?string $title = 'Mon Profil';
    protected static string $view = 'filament.professor.pages.edit-profile';  // Changed to use default Filament view

    public ?array $data = [];

    public function mount(): void
    {
        /** @var Professor $professor */
        $professor = Auth::user();

        $this->form->fill($professor->toArray());
    }

    public function form(Form $form): Form
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
                                        Grid::make()
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
                                            ])
                                            ->columns(4),

                                        Grid::make()
                                            ->schema([
                                                Textarea::make('bio')
                                                    ->label('Biographie')
                                                    ->nullable()
                                                    ->rows(5)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(4),

                                        FileUpload::make('profile_picture')
                                            ->image()
                                            ->disk('public')
                                            ->directory('profile-pictures')
                                            ->visibility('public')
                                            ->downloadable()
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
                                            ->reorderable()
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
                                FileUpload::make('cv')
                                    ->disk('public')
                                    ->directory('cvs')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->visibility('public')
                                    ->downloadable(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        /** @var Professor $professor */
        $professor = Auth::user();

        $professor->update(collect($data)->except(['profile_picture', 'cv'])->toArray());

        if (filled($data['profile_picture'])) {
            $professor->clearMediaCollection('profile_picture');
            $professor->addMedia(storage_path("app/public/{$data['profile_picture']}"))
                ->toMediaCollection('profile_picture');
        }

        if (filled($data['cv'])) {
            $professor->clearMediaCollection('cv');
            $professor->addMedia(storage_path("app/public/{$data['cv']}"))
                ->toMediaCollection('cv');
        }

        Notification::make()->success()->title('Saved successfully')->send();
    }
}
