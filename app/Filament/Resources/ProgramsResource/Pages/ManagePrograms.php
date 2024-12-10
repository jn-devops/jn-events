<?php

namespace App\Filament\Resources\ProgramsResource\Pages;

use App\Filament\Resources\ProgramsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePrograms extends ManageRecords
{
    protected static string $resource = ProgramsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
