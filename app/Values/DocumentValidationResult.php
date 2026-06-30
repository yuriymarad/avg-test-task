<?php

declare(strict_types=1);

namespace App\Values;

final class DocumentValidationResult
{
    public function __construct(
        public readonly array $violations,
    ) {
    }

    public function isValid(): bool
    {
        return $this->violations === [];
    }

    public function errors(): array
    {
        return $this->violations;
    }
}
