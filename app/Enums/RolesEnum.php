<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case OPERATOR = 'operator';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admins',
            self::OPERATOR => 'Operators'
        };
    }
}
