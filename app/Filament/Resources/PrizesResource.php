<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrizesResource\Pages;
use App\Filament\Resources\PrizesResource\RelationManagers;
use App\Models\Prizes;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrizesResource extends Resource
{
    protected static ?string $model = Prizes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(6)
            ->schema([
                TextInput::make('description')
                    ->columnSpan(4)
                    ->label('Name'),
                TextInput::make('winner_count')
                    ->columnSpan(2)
                    ->numeric()
                    ->label('Number of Winners'),
                Select::make('companies')
                    ->options([
                        'RLI' => 'RLI',
                        'ZCC' => 'ZCC',
                        'ECI' => 'ECI',
                        'QRC' => 'QRC',
                        'EXE' => 'EXE',
                        'EDI' => 'EDI',
                        'FIC' => 'FIC',
                        'QRC-JNCC' => 'QRC-JNCC',
                        'EYE' => 'EYE',
                            'EVE' => 'EVE',
                    ])
                    ->hintAction(fn (Select $component) => Forms\Components\Actions\Action::make('select all')
                        ->action(fn () => $component->state([
                            'RLI' => 'RLI',
                            'ZCC' => 'ZCC',
                            'ECI' => 'ECI',
                            'QRC' => 'QRC',
                            'EXE' => 'EXE',
                            'EDI' => 'EDI',
                            'FIC' => 'FIC',
                            'QRC-JNCC' => 'QRC-JNCC',
                            'EYE' => 'EYE',
                            'EVE' => 'EVE',
                        ]))
                    )
                    ->multiple()
                    ->columnSpan(6)
                    ->label('Companies'),
                // Select::make('units')
                //     ->options([
                //         'PDU' => 'PDU',
                //         'LIO' => 'LIO',
                //         'PCU' => 'PCU',
                //         'DDU' => 'DDU',
                //         'EMO' => 'EMO',
                //     ])
                //     ->hintAction(fn (Select $component) => Forms\Components\Actions\Action::make('select all')
                //         ->action(fn () => $component->state([
                //             'PDU' => 'PDU',
                //             'LIO' => 'LIO',
                //             'PCU' => 'PCU',
                //             'DDU' => 'DDU',
                //             'EMO' => 'EMO',
                //         ]))
                //     )
                //     ->multiple()
                //     ->columnSpan(1)
                //     ->hint("IF APPLICABLE")
                //     ->columnSpan(3)
                //     ->label('Units'),
                FileUpload::make('image')
                    ->image()
                    ->label('Image')
                    ->imageEditor()
                    ->columnSpanFull()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(2048)
                    ->openable()
                    ->downloadable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrizes::route('/'),
            'create' => Pages\CreatePrizes::route('/create'),
            'edit' => Pages\EditPrizes::route('/{record}/edit'),
        ];
    }
}
