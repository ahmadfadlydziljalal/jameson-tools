<?php

namespace app\enums;

enum JenisBiayaCategoryEnum: int
{
    case PETTY_CASH = 10;

    case CASH_ADVANCE = 20;
    case COST = 30;
    case EXPENSE = 40;


    public static function map(): array{
        $cases = self::cases();
        return array_combine(
            array_column($cases, 'value'),
            array_column($cases, 'name'),
        );
    }
}
