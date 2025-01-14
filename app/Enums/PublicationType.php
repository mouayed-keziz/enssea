<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PublicationType: string implements HasColor, HasLabel, HasIcon
{
    case BOOK = 'book';
    case RESEARCH_PAPER = 'research_paper';

    public function getLabel(): string
    {
        return match ($this) {
            self::BOOK => 'Livre',
            self::RESEARCH_PAPER => 'Article de recherche',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::BOOK => 'success',
            self::RESEARCH_PAPER => 'primary',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::BOOK => 'heroicon-o-book-open',
            self::RESEARCH_PAPER => 'heroicon-o-document-text',
        };
    }
}
