<?php

declare(strict_types=1);

namespace App\Feature\StringFromDb;

final readonly class StringFromDb
{
    public function __construct(
        public string $string,
    ) {
    }
}
