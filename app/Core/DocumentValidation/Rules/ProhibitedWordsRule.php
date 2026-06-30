<?php

declare(strict_types=1);

namespace App\Core\DocumentValidation\Rules;

use App\Contracts\DocumentValidationRule;
use App\Model\Document;
use App\Values\DocumentValidationViolation;

final class ProhibitedWordsRule implements DocumentValidationRule
{
    private readonly array $prohibitedWords;

    public function __construct(
        array $prohibitedWords,
    ) {
        $this->prohibitedWords = array_map('trim', $prohibitedWords);
    }

    public function validate(Document $document): array
    {
        $violations = [];

        foreach ($this->prohibitedWords as $word) {
            $wordToCheck = mb_strtolower($word);

            if (str_contains(mb_strtolower($document->content), $wordToCheck)) {  
                $violations[] = new DocumentValidationViolation(
                    sprintf('Document content contains prohibited word "%s".', $word),
                );
            }
        }

        return $violations;
    }
}
