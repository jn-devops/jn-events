<?php

namespace App\Filament\Resources\PrizesResource\Pages;

use App\Filament\Resources\PrizesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrizes extends ListRecords
{
    protected static string $resource = PrizesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
