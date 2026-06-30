<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Model\Document;

interface DocumentValidationRule
{
    public function validate(Document $document): array;
}
