<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages;
use App\Filament\Resources\ResourceResource\RelationManagers;
use App\Models\Category;
use App\Models\Resource as ResourceModel;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\UploadedFile;

class ResourceResource extends Resource
{
    protected static ?string $model = ResourceModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('')
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Resource Title')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                ])->columns(2),
                Fieldset::make('')
                ->schema([
                    Forms\Components\TextInput::make('authors')
                        ->label('Authors/Contributors')
                        ->required(),
                    Forms\Components\TextInput::make('authors_affiliation'),
                    Forms\Components\TextInput::make('publisher')
                        ->required(),
                    Forms\Components\DatePicker::make('date_of_publication')
                        ->label('Date of publication'),
                    Forms\Components\TextInput::make('year_of_publication')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('issn_isbn_doi')
                        ->label('ISBN/ISSN/DOI'),
                        ])->columns(3),
                Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('edition'),
                        Forms\Components\TextInput::make('volume'),
                        Forms\Components\TextInput::make('issue'),
                    ])->columns(3),
                Fieldset::make('')
                    ->schema([
                        Forms\Components\RichEditor::make('abstract'),
                        Forms\Components\RichEditor::make('references'),
                    ])->columns(2),
                Fieldset::make('')
                    ->schema([
                        Forms\Components\TextInput::make('tags')
                            ->required(),
                        Forms\Components\TextInput::make('pages')
                            ->numeric()
                            ->required(),
                    ])->columns(2),
                Fieldset::make('File')
                    ->schema([
                        Forms\Components\FileUpload::make('file')
                            ->label('Upload File')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            //->directory('uploads/documents')
                            ->maxSize(60000) // 40 MB
                            ->required()
                            ->preserveFilenames()
                        ->disabled(fn () => ! filament::auth()->user()->is_admin),
                        Forms\Components\FileUpload::make('cover_image')
                            ->image()
                            ->disk('public')
                       // ->directory('uploads/cover_images')
                        ->preserveFilenames(),
                    ])->columns(2),
                ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('authors')
                    ->searchable(),
                // ViewColumn::make('file')
                //     ->label('PDF Preview')
                //     ->view('components.pdf-preview'),
                Tables\Columns\TextColumn::make('authors_affiliation')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('publisher')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_of_publication')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('year_of_publication')
                    ->sortable(),
                Tables\Columns\TextColumn::make('issn_isbn_doi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('edition')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('volume')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('issue')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('abstract')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('references')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tags')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pages')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->toggleable(isToggledHiddenByDefault: true),
//                Tables\Columns\TextColumn::make('file')
//                    ->searchable()
//                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListResources::route('/'),
            'create' => Pages\CreateResource::route('/create'),
            'view' => Pages\ViewResource::route('/{record}'),
            'edit' => Pages\EditResource::route('/{record}/edit'),
        ];
    }
}
