<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('product.name')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable()
                    ->money('VND', 1)
                    ->summarize(Sum::make()->money('VND', 1)),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->default(OrderStatusEnum::NEW)
                    ->options(self::statusOptions()),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('Mark Completed') 
                    ->requiresConfirmation()
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->hidden(fn (Order $record) => $record->status == 'completed')
                    ->action(fn (Order $record) => $record->update(['status' => OrderStatusEnum::COMPLETED])), 
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('Mark as Completed') 
                        ->requiresConfirmation()
                        ->icon(Heroicon::OutlinedCheckBadge)
                        ->action(fn (Collection $records) => $records->each->update(['status' => OrderStatusEnum::COMPLETED]))
                        ->deselectRecordsAfterCompletion()
                ]),
            ]);
    }

    protected static function statusOptions(): array
    {
        $options = [];

        foreach (OrderStatusEnum::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
