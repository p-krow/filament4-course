<?php

namespace App\Filament\Resources\Users\Resources\Orders\Schemas;

use App\Enums\OrderStatusEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Select::make('status')
                    ->options(OrderStatusEnum::class)
                    ->default(OrderStatusEnum::NEW->value)
                    ->required(),
            ]);
    }
}
