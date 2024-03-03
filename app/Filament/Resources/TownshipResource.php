<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TownshipResource\Pages;
use App\Filament\Resources\TownshipResource\RelationManagers;
use App\Models\Region;
use App\Models\Township;
use Filament\Forms;
use Filament\Forms\Components\Group as FormGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TownshipResource extends Resource
{
    protected static ?string $model = Township::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Delivery';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FormGroup::make()->schema([
                    Select::make('region_id')
                        ->label('Region')
                        ->options(Region::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('name')
                        ->placeholder('Bahan')
                        ->label('Township')
                        ->required(),
                    TextInput::make('delivery_fee')
                        ->label('Delivery Fee')
                        ->placeholder('4000')
                        ->required(),
                    TextInput::make('duration')
                        ->label('Durations (Days)')
                        ->placeholder('3')
                        ->required(),
                    TextInput::make('remark')
                        ->placeholder('Additional note for user'),
                ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            'index' => Pages\ListTownships::route('/'),
            'create' => Pages\CreateTownship::route('/create'),
            'edit' => Pages\EditTownship::route('/{record}/edit'),
        ];
    }
}
