<?php

namespace App\Filament\Resources;

use App\Events\SetRafflePrize;
use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\RelationManagers;
use App\Models\Competition;
use App\Models\CompetitionJudge;
use App\Models\Participant;
use App\Models\Score;
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

class CompetitionResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Repeater::make('judges')
                        ->relationship()
                        ->simple(
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                        )
                        ->columnSpanFull()
                        ->grid(2),
                    Forms\Components\Repeater::make('participants')
                        ->relationship()
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->imageEditor()
                                ->required(),
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('category')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('song')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),
                            Forms\Components\Placeholder::make('scores')
                                ->content(function (Forms\Components\Placeholder $component) {
                                    $model = $component->getContainer()->model;

                                    $judgesScores = $model->scores->groupBy('judge_id')->map(function ($scores, $judgeId) {
                                        $judgeName = CompetitionJudge::find($judgeId)->name;
                                        $criteriaScores = $scores->mapWithKeys(function ($score) {
                                            return [$score->criteria => $score->score];
                                        });

                                        $totalScore = $criteriaScores->sum();

                                        return [
                                            'judge' => $judgeName,
                                            'criteriaScores' => $criteriaScores,
                                            'total' => $totalScore,
                                        ];
                                    });

                                    $criteriaHeaders = $model->scores->pluck('criteria')->unique();

                                    // Build the table
                                    $tableHtml = '<table style="border-collapse: collapse; width: 100%; font-size: 14px;">';
                                    $tableHtml .= '<thead>';
                                    $tableHtml .= '<tr style="border-bottom: 1px solid black;">';
                                    $tableHtml .= '<th style="text-align: left; padding: 4px;">Judge</th>';

                                    // Generate the header for criteria
                                    foreach ($criteriaHeaders as $criteria) {
                                        $tableHtml .= "<th style=\"text-align: center; padding: 4px;\">{$criteria}</th>";
                                    }
                                    $tableHtml .= '<th style="text-align: center; padding: 4px;">Total</th>';
                                    $tableHtml .= '</tr>';
                                    $tableHtml .= '</thead>';
                                    $tableHtml .= '<tbody>';

                                    // Generate rows for each judge
                                    foreach ($judgesScores as $judgeScores) {
                                        $tableHtml .= '<tr style="border-bottom: 1px solid #ddd;">';
                                        $tableHtml .= "<td style=\"text-align: left; padding: 4px;\">{$judgeScores['judge']}</td>";

                                        foreach ($criteriaHeaders as $criteria) {
                                            $score = $judgeScores['criteriaScores']->get($criteria, '-');
                                            $tableHtml .= "<td style=\"text-align: center; padding: 4px;\">{$score}</td>";
                                        }

                                        $tableHtml .= "<td style=\"text-align: center; padding: 4px;\">{$judgeScores['total']}</td>";
                                        $tableHtml .= '</tr>';
                                    }

                                    $tableHtml .= '</tbody></table>';

                                    return new HtmlString($tableHtml);
                                })
                                ->columnSpanFull(),


                        ])
                        ->extraItemActions([
                                Action::make('resetScores')
                                    ->button()
                                    ->label('Reset Scores')
                                    ->action(function (array $arguments,$component): void {
                                        $participant_id = $component->getLivewire()->data['participants'][$arguments['item']]['id'];
                                        Participant::find($participant_id)->scores()->delete();
                                    }),
                        ])
                        ->columns(4)
                        ->columnSpanFull()
                ])->columnSpan(3),
                Forms\Components\Section::make()->schema([
                    Placeholder::make('live_poll_qr_code')
                        ->label('Winners QR Code')
                        ->content(function (Get $get, Model $record) {
                            return \LaraZeus\Qr\Facades\Qr::render(
                                data:  sprintf(
                                    '%s/competition-score-board/%s',
                                    config('app.url'),
                                    $record->id,
                                ),
                            );
                        })->hiddenOn('create'),
                    Placeholder::make('live_poll_link')
                        ->label('Winners Link')
                        ->content(function (Get $get, Model $record) {
                            $url = sprintf(
                                '%s/competition-score-board/%s',
                                config('app.url'),
                                $record->id,
                            );
                            return new HtmlString('<a href="' . $url . '" target="_blank" rel="noopener noreferrer" class="text-blue-500 underline">' . $url . '</a>');
                        })->hiddenOn('create'),
                    Placeholder::make('Judges Vote Links')
                        ->content(function ($record) {
                            $judges = $record->judges;
                            $links = '<table style="border-collapse: collapse; width: 100%;">';
                            $links .= '<tbody>';

                            foreach ($judges as $judge) {
                                $links .= sprintf(
                                    '<tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 8px;  white-space: nowrap;">%s</td>
                    <td style="padding: 8px;  word-wrap: break-word; overflow-wrap: break-word;">
                        <a href="%s/competition/%s/%s/%s" target="_blank">%s/competition/%s/%s/%s</a>
                    </td>
                </tr>',
                                    htmlspecialchars($judge->name),  // Judge name
                                    config('app.url'),               // Base URL
                                    $record->id,                     // Competition ID
                                    $judge->id,                      // Judge ID
                                    urlencode($judge->name),         // URL-safe judge name
                                    config('app.url'),               // Base URL (for anchor text)
                                    $record->id,                     // Competition ID (for anchor text)
                                    $judge->id,                      // Judge ID (for anchor text)
                                    htmlspecialchars($judge->name)   // Judge name (for anchor text)
                                );
                            }

                            $links .= '</tbody></table>';

                            return new HtmlString($links);
                        })
                        ->hiddenOn('create'),

        Placeholder::make('created_at')
                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),

                    Placeholder::make('updated_at')
                        ->content(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;'))
                ])->columnSpan(1),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListCompetitions::route('/'),
            'create' => Pages\CreateCompetition::route('/create'),
            'edit' => Pages\EditCompetition::route('/{record}/edit'),
        ];
    }
}
