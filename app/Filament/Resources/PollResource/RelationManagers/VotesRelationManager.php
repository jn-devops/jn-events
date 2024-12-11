<?php

namespace App\Filament\Resources\PollResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class VotesRelationManager extends RelationManager
{
    protected static string $relationship = 'votes';
    public function isReadOnly(): bool
    {
        return false;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('employee_id')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->formatStateUsing(function (string $state) {
                        $date = Carbon::parse($state);
                        $formattedDate = $date->format('F j, Y');
                        $formattedTime = $date->format('g:i A');
                        $timeAgo = $date->diffForHumans();
                        return $formattedDate . '<br>' . $formattedTime  .'<br><small>' . $timeAgo . '</small>';
                    })
                    ->html()
                    ->wrap()
                    ->grow(false),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee')
                    ->formatStateUsing(function (Model $record) {
                        $name =implode(' ', array_filter([
                            $record->employee->first_name ?? '',
                            $record->employee->middle_name ?? '',
                            $record->employee->last_name ?? '',
                        ]));

                        return $name. '<br>'.$record->employee_id??'';
                    })
                    ->grow(false)
                    ->html()
                    ->wrap()
                    ->summarize(Count::make()->label('Total Votes')),
                Tables\Columns\TextColumn::make('pollOption.option')->label('Vote')
                    ->summarize(Summarizer::make()
                        ->label('Tally')
//                        ->using(fn (\Illuminate\Database\Query\Builder $query): string => $query
//                            ->select('poll_option_id')
//                            ->groupBy('poll_option_id')
//                            ->count())
                        ->using(function (\Illuminate\Database\Query\Builder $query) {
                            // Join votes and poll_options, group by poll_option_id, and count
                            return $query
                                ->join('votes', 'votes.poll_option_id', '=', 'poll_options.id') // Join votes table
                                ->groupBy('poll_options.id') // Group by poll options
                                ->selectRaw('poll_options.option, COUNT(votes.id) as total_votes')
                                ->get()
                                ->map(fn ($row) => "{$row->option}: {$row->total_votes}")
                                ->join(', '); // Return a readable string
                        })
                    ),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
