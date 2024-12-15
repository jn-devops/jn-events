<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PollResource\Pages;
use App\Filament\Resources\PollResource\RelationManagers;
use App\Models\Poll;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class PollResource extends Resource
{
    protected static ?string $model = Poll::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(10),
                        Forms\Components\Toggle::make('active')
                            ->inline(false)
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('options')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('icon_image')
                                    ->image()
                                    ->downloadable()
//                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->downloadable()
//                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('option')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),

                            ])
                            ->columns(4)
                            ->columnSpanFull()

                    ])->columns(12)->columnSpan(2),
                Forms\Components\Section::make()
                    ->schema([
                        Placeholder::make('live_poll_qr_code')
                            ->label('Live Poll QR Code')
                            ->content(function (Get $get, Model $record) {
                                return \LaraZeus\Qr\Facades\Qr::render(
                                    data:  sprintf(
                                        '%s/live-pop-culture-icon/%s',
                                        config('app.url'),
                                        $record->id,
                                    ),
                                );
                            })->hiddenOn('create'),
                        Placeholder::make('live_poll_link')
                            ->label('Live Poll Link')
                            ->content(function (Get $get, Model $record) {
                                $url = sprintf(
                                    '%s/live-pop-culture-icon/%s',
                                    config('app.url'),
                                    $record->id,
                                );
                                return new HtmlString('<a href="' . $url . '" target="_blank" rel="noopener noreferrer" class="text-blue-500 underline">' . $url . '</a>');
                            })->hiddenOn('create'),
                        Placeholder::make('vote_qr_code')
                            ->label('Vote QR Code')
                            ->content(function (Get $get, Model $record) {
                                return \LaraZeus\Qr\Facades\Qr::render(
                                    data:  sprintf(
                                        '%s/pop-culture-icon/%s',
                                        config('app.url'),
                                        $record->id,
                                    ),
                                );
                            })->hiddenOn('create'),
                        Placeholder::make('vote_link')
                            ->label('Vote Link')
                            ->content(function (Get $get, Model $record) {
                                $url = sprintf(
                                    '%s/pop-culture-icon/%s',
                                    config('app.url'),
                                    $record->id,
                                );
                                return new HtmlString('<a href="' . $url . '" target="_blank" rel="noopener noreferrer" class="text-blue-500 underline">' . $url . '</a>');
                            })->hiddenOn('create'),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
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
            RelationManagers\VotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolls::route('/'),
            'create' => Pages\CreatePoll::route('/create'),
            'edit' => Pages\EditPoll::route('/{record}/edit'),
        ];
    }
}
