<?php

namespace App\Filament\Pages;

use App\Filament\Navigation\Sidebar;
use App\Settings\LandingPageContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageLangingPageContent extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Gestion de la Page d\'Accueil';
    protected static ?string $navigationGroup = Sidebar::LANDING_CONTENT['group'];
    protected static ?int $navigationSort = Sidebar::LANDING_CONTENT['sort'];
    public function getTitle(): string
    {
        return 'Gestion de la Page d\'Accueil';
    }

    public function getSubheading(): ?string
    {
        return 'Personnalisez le contenu de la page d\'accueil de votre site web.';
    }

    protected static string $settings = LandingPageContent::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section Hero
                Forms\Components\Section::make('Section Hero')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('hero_header')
                            ->label('Titre Hero')
                            ->required(),
                        Forms\Components\Textarea::make('hero_description')
                            ->label('Description Hero')
                            ->rows(5)
                            ->required(),
                    ]),

                // Section Contact
                Forms\Components\Section::make('Informations de Contact')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Téléphone')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('location')
                            ->label('Adresse')
                            ->required(),
                    ]),

                // Section Réseaux Sociaux
                Forms\Components\Section::make('Liens des Réseaux Sociaux')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('URL Facebook')
                            ->url(),
                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('URL LinkedIn')
                            ->url(),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('URL Instagram')
                            ->url(),
                    ]),

                // Section À Propos de l'École
                Forms\Components\Section::make('À Propos de l\'École')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Textarea::make('about_school')
                            ->label('À Propos de l\'École')
                            ->rows(5)
                            ->required(),
                    ]),
            ]);
    }
}
