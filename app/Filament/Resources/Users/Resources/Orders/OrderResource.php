<?php

namespace App\Filament\Resources\Users\Resources\Orders;

use App\Filament\Resources\Users\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Users\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Users\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Users\Resources\Orders\Tables\OrdersTable;
use App\Filament\Resources\Users\UserResource;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = UserResource::class;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
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
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
