<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Resources\ProfessorResource\Pages\EditProfessor as PagesEditProfessor;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Professor\Resources\ProfessorResource\Pages\EditProfessor;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;

class ProfessorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('professor')
            ->path('professor')
            ->brandName(config('app.name') . ' (espace professeur)')
            ->spa()
            ->login()
            ->authGuard("professor")
            ->colors([
                'primary' => Color::Violet,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverResources(in: app_path('Filament/Professor/Resources'), for: 'App\\Filament\\Professor\\Resources')
            ->discoverPages(in: app_path('Filament/Professor/Pages'), for: 'App\\Filament\\Professor\\Pages')
            ->pages([
                Pages\Dashboard::class,
                // EditProfessor::class, // Link to the “edit-profile” route
                // \App\Filament\Professor\Pages\EditProfile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Professor/Widgets'), for: 'App\\Filament\\Professor\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make('Mon Profil')
                    ->url(function () {
                        return EditProfessor::getUrl(["record" => Auth::id()]);
                    })
                    ->icon('heroicon-o-user')
                    ->sort(0),
            ]);
    }
}
