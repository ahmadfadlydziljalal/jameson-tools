<?php

namespace app\enums;

enum KodeVoucherEnum: int
{
    case CR = 1;
    case CP = 2;

    public static function map(): array{
        $cases = self::cases();
        return array_combine(
            array_column($cases, 'name'),
            array_column($cases, 'value')
        );
    }
}
