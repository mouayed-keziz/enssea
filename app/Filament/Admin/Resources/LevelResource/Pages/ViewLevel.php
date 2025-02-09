<?php

namespace App\Filament\Admin\Resources\LevelResource\Pages;

use App\Filament\Admin\Resources\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLevel extends ViewRecord
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('subjects')
                ->label('Gérer les matières')
                ->icon('heroicon-o-book-open')
                ->url(fn () => $this->getResource()::getUrl('subjects', ['record' => $this->getRecord()])),
            Actions\EditAction::make(),
        ];
    }
}
