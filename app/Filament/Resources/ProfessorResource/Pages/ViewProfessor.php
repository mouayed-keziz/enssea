<?php

namespace App\Filament\Resources\ProfessorResource\Pages;

use App\Filament\Resources\ProfessorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProfessor extends ViewRecord
{
    protected static string $resource = ProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
