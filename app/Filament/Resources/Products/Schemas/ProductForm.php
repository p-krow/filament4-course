<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductStatusEnum;
use App\Filament\Tables\CategoriesTable;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        ModalTableSelect::make('category_id')
                            ->relationship('category', 'name')
                            ->tableConfiguration(CategoriesTable::class),
                        TextInput::make('name')
                            ->required()
                            ->minLength(5)
                            ->maxLength(20)
                            ->unique(table: \App\Models\Product::class, column: 'name', ignoreRecord: true),
                        TextInput::make('price')
                            ->required()
                            ->prefix('VND')
                            ->rule('numeric'),
                        RichEditor::make('description')
                            ->columnSpanFull()
                            ->required(),
                    ]),
                Section::make('Trạng thái sản phảm')
                    ->schema([
                        Radio::make('status')
                            ->label('Thông tin tồn kho')
                            ->options(ProductStatusEnum::class)
                            ->inline()
                            ->default(ProductStatusEnum::IN_STOCK->value),
                        Toggle::make('is_active')
                            ->label('Sản phẩm đang mở bán')
                            ->inline()
                            ->default(true),
                    ]),
                Section::make('Tags')
                    ->schema([
                        Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple(),
                        SpatieMediaLibraryFileUpload::make('attachments')
                            ->multiple()
                            ->reorderable()
                    ]),
            ])
            ->columns(1);
    }
}
