<?php

namespace App\Filament\Admin\Resources\EventAnnouncementResource\Pages;

use App\Filament\Admin\Resources\EventAnnouncementResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEventAnnouncement extends ViewRecord
{
    protected static string $resource = EventAnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
