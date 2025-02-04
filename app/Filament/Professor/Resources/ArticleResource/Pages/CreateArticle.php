<?php

namespace App\Filament\Professor\Resources\ArticleResource\Pages;

use App\Filament\Professor\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
}
