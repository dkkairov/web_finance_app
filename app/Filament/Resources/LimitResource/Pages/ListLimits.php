<?php

namespace App\Filament\Resources\LimitResource\Pages;

use App\Filament\Resources\LimitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLimits extends ListRecords
{
    protected static string $resource = LimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
