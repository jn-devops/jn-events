<?php

namespace App\Filament\Resources;

use App\Events\DrawRaffle;
use App\Events\SetRafflePrize;
use App\Events\SetWinner;
use App\Events\VoteUpdated;
use App\Filament\Resources\RaffleResource\Pages;
use App\Filament\Resources\RaffleResource\RelationManagers;
use App\Models\Employees;
use App\Models\Raffle;
use App\Models\RaffleWinner;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class RaffleResource extends Resource
{
    protected static ?string $model = Raffle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(12),
                        Forms\Components\Repeater::make('prizes')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('id')
                                    ->columnSpanFull()
                                    ->readonly(),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('prize_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1),
                                Forms\Components\Select::make('companies')
                                    ->multiple()
                                    ->options(Employees::select('company')->distinct()->pluck('company')->mapWithKeys(function ($company) {
                                        return [$company => $company];
                                    })->toArray())
                                    ->required()
                                ->columnSpan(3),
                                Forms\Components\Select::make('units')
                                    ->multiple()
                                    ->options(Employees::select('unit')
                                        ->whereNotNull('unit')
                                        ->where('unit', '!=', '')
                                        ->distinct()
                                        ->pluck('unit')
                                        ->mapWithKeys(function ($unit) {
                                            return [$unit => $unit];
                                        })->toArray()
                                    )
                                    ->required()
                                    ->live()
//                                    ->hintAction(function ($state){
//                                        return Action::make('select_all')
//                                            ->label('Select All')
//                                            ->action(function ()use ($state) {
//                                                $distinctUnits = Employees::select('unit')
//                                                    ->whereNotNull('unit')
//                                                    ->where('unit', '!=', '')
//                                                    ->distinct()
//                                                    ->pluck('unit');
//                                                $state= $distinctUnits;
//                                            });
//                                    })
                                    ->columnSpan(3),
                            ])
                            ->itemLabel(function (array $state): ?string {
                                $number_of_winners = 0;
                                $number_of_winners = RaffleWinner::where('raffle_id',$state['raffle_id'])
                                    ->where('raffle_prize_id',$state['id'])
                                    ->count();
                                  return  'Available ('.$number_of_winners.'/'.$state['quantity'].')';
                            })
                            ->extraItemActions([
                                Action::make('setCurrentPrize')
                                    ->button()
                                    ->label('Set As Current Prize')
                                    ->action(function (array $arguments, Forms\Components\Repeater $component): void {
                                        $itemData = $component->getItemState($arguments['item']);
                                        try {
                                            broadcast(new SetRafflePrize($itemData['id']));
                                        }catch (\Exception $exception){
                                            throw new $exception;
                                        }
                                    }),
                                Action::make('drawRaffle')
                                    ->button()
                                    ->label('Draw Raffle')
                                    ->action(function (array $arguments, Forms\Components\Repeater $component): void {
                                        $itemData = $component->getItemState($arguments['item']);
                                        try {
                                            broadcast(new DrawRaffle($itemData['id']));
                                        }catch (\Exception $exception){
                                            throw new $exception;
                                        }
                                    }),
                                Action::make('setWinner')
                                    ->button()
                                    ->label('Set Winner')
                                    ->action(function (array $arguments, Forms\Components\Repeater $component): void {
                                        $itemData = $component->getItemState($arguments['item']);
                                        try {
                                            broadcast(new SetWinner($itemData['id']));
                                        }catch (\Exception $exception){
                                            throw new $exception;
                                        }
                                    }),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                    ])
                    ->columns(12)->columnSpan(2),
                Forms\Components\Section::make()
                    ->schema([

                        Placeholder::make('created_at')
                            ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),

                        Placeholder::make('updated_at')
                            ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;'))
                    ])->columnSpan(1)->columns(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ListRaffles::route('/'),
            'create' => Pages\CreateRaffle::route('/create'),
            'edit' => Pages\EditRaffle::route('/{record}/edit'),
        ];
    }
}
