<?php

declare(strict_types=1);

namespace App\Core\DocumentValidation\Rules;

use App\Contracts\DocumentValidationRule;
use App\Model\Document;
use App\Values\DocumentValidationViolation;

final class RequiredMetadataFieldsRule implements DocumentValidationRule
{
    private readonly array $requiredFields;

    public function __construct(array $requiredFields)
    {
        $this->requiredFields = array_values(array_unique($requiredFields));
    }

    public function validate(Document $document): array
    {
        $violations = [];

        foreach ($this->requiredFields as $field) {
            if (!$document->hasMetadata($field)) {
                $violations[] = new DocumentValidationViolation(
                    sprintf('Required metadata field "%s" is missing.', $field),
                );
            }
        }

        return $violations;
    }
}
