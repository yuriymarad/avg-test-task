<?php

declare(strict_types=1);

namespace App\Core\DocumentValidation;

use App\Model\Document;
use App\Values\DocumentValidationRuleSet;
use App\Values\DocumentValidationResult;

final class DocumentValidator
{
    public function validate(Document $document, DocumentValidationRuleSet $rules): DocumentValidationResult
    {
        $violations = [];

        foreach ($rules as $rule) {
            foreach ($rule->validate($document) as $violation) {
                $violations[] = $violation;
            }
        }

        return new DocumentValidationResult($violations);
    }
}
