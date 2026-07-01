<?php

declare(strict_types=1);

namespace App\Values;

final readonly class DocumentValidationViolation
{
    public function __construct(
        public string $message,
    ) {
    }
}
