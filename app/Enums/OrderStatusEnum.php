<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatusEnum: string implements HasLabel, HasColor
{
    case NEW = 'NEW';
    case SHIPPING = 'SHIPPING';
    case COMPLETED = 'COMPLETED';

    public function getLabel(): ?string 
    {
        return $this->value;
    }
 
    public function getColor(): ?string
    {
        return match ($this) {
            self::NEW => 'success',
            self::SHIPPING => 'primary',
            self::COMPLETED => 'info',
        };
    } 
}
