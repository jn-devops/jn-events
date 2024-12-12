<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckinResource\Pages;
use App\Filament\Resources\CheckinResource\RelationManagers;
use App\Models\Checkin;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class CheckinResource extends Resource
{
    protected static ?string $model = Checkin::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->label('Employee ID')
                    ->nullable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('created_at')
                    ->date()
                    ->orderQueryUsing(fn (Builder $query, string $direction) => $query->orderBy('created_at', 'desc'))
            ])
            ->defaultSort('created_at','desc')
            ->persistFiltersInSession()
            ->columns([
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->grow(true)
                    ->searchable()
                    ->summarize(\Filament\Tables\Columns\Summarizers\Count::make()),
                Tables\Columns\TextColumn::make('created_at')
                    ->formatStateUsing(function ($state) {
                        return new HtmlString($state->format('M j, Y') . '<br>' . $state->format('h:i A'));
                    })
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

            ])
            ->filters([
                //
                Filter::make('created_at')
                    ->form([DatePicker::make('date')])
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['date']) {
                            return null;
                        }

                        return 'Created at ' . Carbon::parse($data['date'])->toFormattedDateString();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCheckins::route('/'),
        ];
    }
}
