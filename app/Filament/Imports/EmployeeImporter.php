<?php

namespace App\Filament\Imports;

use App\Models\Employees;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class EmployeeImporter extends Importer
{
    protected static ?string $model = Employees::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('employee_id')
                ->label("EmployeeID")
                ->requiredMapping(),
            ImportColumn::make('company')
                ->label("Company")
                ->requiredMapping(),
            ImportColumn::make('last_name')
                ->label("LastName")
                ->requiredMapping(),
            ImportColumn::make('first_name')
                ->label("FirstName")
                ->requiredMapping(),
            ImportColumn::make('middle_name')
                ->label("MiddleName")
                ->requiredMapping(),
            ImportColumn::make('department')
                ->label("Department")
                ->requiredMapping(),
            ImportColumn::make('floor')
                ->label("Floor")
                ->requiredMapping(),
            ImportColumn::make('unit_group')
                ->label("UnitGroup")
                ->requiredMapping(),
            ImportColumn::make('code')
                ->label("Code")
                ->requiredMapping(),
            ImportColumn::make('Unit')
                ->label("Unit")
                ->requiredMapping(),
            ImportColumn::make('code_1')
                ->label("Code1")
                ->requiredMapping(),
        ];
    }

    public function resolveRecord(): ?Employees
    {
        return Employees::firstOrNew([
            // Update existing records, matching them by `$this->data['column_name']`
            'employee_id' => $this->data['employee_id'],
        ]);

        return new Employees();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your employee import import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
