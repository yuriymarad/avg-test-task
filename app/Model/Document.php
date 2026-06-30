<?php

declare(strict_types=1);

namespace App\Model;

final readonly class Document
{
    public function __construct(
        public string $id,
        public string $tenantId,
        public string $content,
        public array $metadata,
    ) {
    }

    public function sizeInBytes(): int
    {
        return strlen($this->content);
    }

    public function hasMetadata(string $field): bool
    {
        return isset($this->metadata[$field]) 
            && trim((string) $this->metadata[$field]) !== '';
    }
}
