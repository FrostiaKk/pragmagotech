<?php

namespace App\Domain\Model\Loan;

enum Term: int
{
    case MONTHS_12 = 12;
    case MONTHS_24 = 24;

    public static function list(): array
    {
        $list = [];
        foreach (self::cases() as $term) {
            $list[] = $term->value;
        }

        return $list;
    }
}
