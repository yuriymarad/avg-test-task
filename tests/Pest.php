<?php

declare(strict_types=1);

use App\Core\DocumentValidation\DocumentValidator;
use App\Model\Document;

function makeDocumentValidator(): DocumentValidator
{
    return (new DocumentValidator());
}

function makeDocument(string $content = '', array $metadata = []): Document
{
    return new Document(
        id: 'doc-001',
        tenantId: 'tenant-001',
        content: $content,
        metadata: $metadata,
    );
}