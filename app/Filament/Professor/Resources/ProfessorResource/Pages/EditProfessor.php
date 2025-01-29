<?php

namespace App\Filament\Professor\Resources\ProfessorResource\Pages;

use App\Filament\Professor\Resources\ProfessorResource;
use App\Models\Professor;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EditProfessor extends EditRecord
{
    protected static string $resource = ProfessorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getRecord(): Model
    {
        return Professor::findOrFail(Auth::id());
    }

    protected function authorizeAccess(): void
    {
        // Skip default authorization checks
    }

    protected function getRedirectUrl(): string
    {
        return EditProfessor::getUrl(["record" => Auth::id()]);
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Mon Profil' => false,
        ];
    }
}
