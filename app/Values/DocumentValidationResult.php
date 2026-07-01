<?php

declare(strict_types=1);

namespace App\Values;

final readonly class DocumentValidationResult
{
    public function __construct(
        public array $violations,
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
