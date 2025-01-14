<?php

namespace App\Filament\Professor\Resources\VideoResource\Pages;

use App\Filament\Professor\Resources\VideoResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateVideo extends CreateRecord
{
    protected static string $resource = VideoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['professor_id'] = Auth::id();
        return $data;
    }
}
