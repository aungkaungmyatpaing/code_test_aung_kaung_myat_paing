<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Components\Group as FormGroup;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Books';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FormGroup::make()->schema([
                    TextInput::make('name')
                        ->label('Book Name')
                        ->placeholder('Harry Potter and the Philosopher\'s Stone')
                        ->required(),
                    RichEditor::make('description')
                        ->label('Description')
                        ->required(),
                    TextInput::make('price')
                        ->label('Price')
                        ->placeholder('10000')
                        ->required(),
                    TextInput::make('discount')
                        ->label('Discount (%)')
                        ->default(0),
                    TextInput::make('quantity')
                        ->label('Quantity')
                        ->default(50)
                        ->required(),
                ]),

                FormGroup::make([
                    Select::make('author_id')
                        ->label('Author')
                        ->options(Author::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Select::make('genre_id')
                        ->label('Genre')
                        ->options(Genre::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    ToggleButtons::make('is_public')
                        ->label('Public')
                        ->default(true)
                        ->boolean()
                        ->grouped()
                        ->required(),

                    SpatieMediaLibraryFileUpload::make('book-cover')
                        ->collection('book-cover')
                        ->conversion('thumb')
                        ->nullable(),

                ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('book-cover')
                    ->collection('book-cover')
                    ->defaultImageUrl(asset('assets/images/default.png'))
                    ->conversion('thumb'),
                TextColumn::make('name')->label('Book Name'),
                TextColumn::make('author.name')->label('Author'),
                TextColumn::make('genre.name')->label('Genre'),
                TextColumn::make('price')->label('Price'),
                TextColumn::make('discount')->label('Discount'),
                TextColumn::make('stock')->label('Stock'),
                TextColumn::make('is_public')
                    ->formatStateUsing(fn (Book $book) => $book->is_public ? 'Public' : 'Private')
                    ->badge(fn (Book $book) => $book->is_public ? 'success' : 'danger')
                    ->label('Status'),

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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
