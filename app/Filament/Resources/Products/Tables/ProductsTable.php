<?php

namespace App\Filament\Resources\Products\Tables;

use App\Enums\ProductStatusEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\Width;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('name')
                    ->sortable()
                    ->rules(['required', 'min:5', 'max:20'])
                    ->searchable(isIndividual: false, isGlobal: true),
                TextColumn::make('price')
                    // ->formatStateUsing(fn (int $state): float => $state / 100)
                    ->money('VND', 100)
                    ->sortable(),
                SelectColumn::make('status')
                    ->options(self::statusOptions())
                    ->searchableOptions()
                    ->native(false),
                ToggleColumn::make('is_active')
                    ->label('Selling?'),
                TextColumn::make('category.name'),
                TextColumn::make('tags.name')
                    ->badge(),
                TextColumn::make('created_at')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(self::statusOptions()),
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                    // ->url(fn (Product $product): string => CategoryResource::getUrl('edit', ['record' => $product->category_id])), 

                Filter::make('created_from')
                    ->schema([
                        DatePicker::make('created_from'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            );
                    }),
                Filter::make('created_until')
                    ->schema([
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function statusOptions(): array
    {
        $options = [];

        foreach (ProductStatusEnum::cases() as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }
}
