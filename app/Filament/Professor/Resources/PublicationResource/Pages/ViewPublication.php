<?php

namespace App\Filament\Professor\Resources\PublicationResource\Pages;

use App\Filament\Professor\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPublication extends ViewRecord
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
