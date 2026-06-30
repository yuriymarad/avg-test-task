<?php

declare(strict_types=1);

namespace App\Values;

final class DocumentValidationViolation
{
    public function __construct(
        public readonly string $message,
    ) {
    }
}
