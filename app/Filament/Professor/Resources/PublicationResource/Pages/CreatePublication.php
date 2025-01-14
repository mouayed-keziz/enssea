<?php

namespace App\Filament\Professor\Resources\PublicationResource\Pages;

use App\Filament\Professor\Resources\PublicationResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['professor_id'] = Auth::id();
        return $data;
    }
}
