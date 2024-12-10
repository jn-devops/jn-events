<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeesResource\Pages;
use App\Filament\Resources\EmployeesResource\RelationManagers;
use App\Models\Employees;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesResource extends Resource
{
    protected static ?string $model = Employees::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('department')
                    ->maxLength(255),
                Forms\Components\TextInput::make('floor')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_group')
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('code_1')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('last_name','asc')
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('company')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->sortable(
                        true, // Enables sorting
                        function ($query, $direction) {
                            $query->orderByRaw('CAST(employee_id AS UNSIGNED) ' . $direction);
                        }
                    )
                    ->summarize(\Filament\Tables\Columns\Summarizers\Summarizer::make()
                        ->using(fn (\Illuminate\Database\Query\Builder $query): string => $query->count('employee_id'))
                    )
                    ->searchable(),

                Tables\Columns\TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('department')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('floor')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_group')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_1')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageEmployees::route('/'),
        ];
    }
}
