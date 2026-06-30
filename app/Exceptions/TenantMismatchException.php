<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class TenantMismatchException extends RuntimeException
{
    public static function forDocument(
        string $documentId,
        string $expectedTenantId,
        string $actualTenantId,
    ): self {
        return new self(sprintf(
            'Document "%s" belongs to tenant "%s" but not for the expected tenant "%s".',
            $documentId,
            $actualTenantId,
            $expectedTenantId,
        ));
    }
}
