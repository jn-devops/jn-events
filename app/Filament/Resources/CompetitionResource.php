<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompetitionResource\Pages;
use App\Filament\Resources\CompetitionResource\RelationManagers;
use App\Models\Competition;
use Filament\Forms;
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
                        ])
                        ->columns(4)
                        ->columnSpanFull()
                ])->columnSpan(2),
                Forms\Components\Section::make()->schema([
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
            ])->columns(3);
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
