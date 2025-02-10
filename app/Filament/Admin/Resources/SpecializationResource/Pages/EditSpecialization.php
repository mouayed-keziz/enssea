<?php

namespace App\Filament\Admin\Resources\SpecializationResource\Pages;

use App\Filament\Admin\Resources\SpecializationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecialization extends EditRecord
{
    protected static string $resource = SpecializationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\Action::make('levels')
                ->label('Levels')
                ->link()
                ->url(fn($record): string => "/admin/specializations/{$record->id}/levels"),
        ];
    }
}
