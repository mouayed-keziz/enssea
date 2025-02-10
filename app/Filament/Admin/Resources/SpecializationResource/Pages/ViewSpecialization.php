<?php

namespace App\Filament\Admin\Resources\SpecializationResource\Pages;

use App\Filament\Admin\Resources\SpecializationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSpecialization extends ViewRecord
{
    protected static string $resource = SpecializationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('levels')
                ->label('Levels')
                ->link()
                ->url(fn($record): string => "/admin/specializations/{$record->id}/levels"),
        ];
    }
}
