<?php

namespace App\Filament\Admin\Resources\LevelResource\Pages;

use App\Filament\Admin\Resources\LevelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLevel extends EditRecord
{
    protected static string $resource = LevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('subjects')
                ->label('Gérer les matières')
                ->icon('heroicon-o-book-open')
                ->url(fn () => $this->getResource()::getUrl('subjects', ['record' => $this->getRecord()])),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
