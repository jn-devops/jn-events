<?php

namespace App\Filament\Resources\EmployeesResource\Pages;

use App\Filament\Imports\EmployeeImporter;
use App\Filament\Resources\EmployeesResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployees extends ManageRecords
{
    protected static string $resource = EmployeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->importer(EmployeeImporter::class),
        ];
    }
}
