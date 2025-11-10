<?php

namespace App\Enums;

enum TransactionType: string
{
    case IN  = 'in';
    case OUT = 'out';

    public function label()
    {
        return match ($this) {
            self::IN  => 'Masuk',
            self::OUT => 'Keluar',
        };
    }
}
