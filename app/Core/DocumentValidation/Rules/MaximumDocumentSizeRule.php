<?php

declare(strict_types=1);

namespace App\Core\DocumentValidation\Rules;

use App\Contracts\DocumentValidationRule;
use App\Model\Document;
use App\Values\DocumentValidationViolation;

final class MaximumDocumentSizeRule implements DocumentValidationRule
{
    public function __construct(
        private readonly int $maxBytes,
    ) {
        if ($maxBytes <= 0) {
            throw new \InvalidArgumentException('The max file size parameter must be greater than 0.');
        }
    }

    public function validate(Document $document): array
    {
        $size = $document->sizeInBytes();

        if ($size <= $this->maxBytes) {
            return [];
        }

        return [
            new DocumentValidationViolation(
                sprintf('Document size %d exceeds maximum limit.', $size),
            ),
        ];
    }
}
