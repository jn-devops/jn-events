<?php

namespace App\Filament\Exports;

use App\Models\Checkin;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CheckinExporter extends Exporter
{
    protected static ?string $model = Checkin::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('date')
                ->formatStateUsing(fn (Checkin $record): string => Carbon::parse($record->created_at)->format('F j, Y'))
                ->label('Date Logged'),
            ExportColumn::make('time')
                ->formatStateUsing(fn (Checkin $record): string => Carbon::parse($record->created_at)->addHours(8)->format('h:i A'))
                ->label('Time Logged'),
            ExportColumn::make('employee_id_number')
                ->label('ID No.'),
            ExportColumn::make('name')
                ->label('Name'),
            ExportColumn::make('company')
                ->formatStateUsing(fn (Checkin $record): string => $record->employee->company ?? '')
                ->label('Company'),
            ExportColumn::make('unit')
                ->formatStateUsing(fn (Checkin $record): string => $record->employee->unit ?? '')
                ->label('Unit'),
            ExportColumn::make('unit_group')
                ->formatStateUsing(fn (Checkin $record): string => $record->employee->unit_group ?? '')
                ->label('Unit Group'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your checkin export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
