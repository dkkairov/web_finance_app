<?php

namespace App\Filament\Resources\LimitResource\Pages;

use App\Filament\Resources\LimitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLimit extends EditRecord
{
    protected static string $resource = LimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
