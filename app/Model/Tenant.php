<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Tenant
{
    public function __construct(
        public string $id,
    ) {
    }
}
