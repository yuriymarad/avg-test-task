<?php

declare(strict_types=1);

namespace App\Values;

use App\Contracts\DocumentValidationRule;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

final readonly class DocumentValidationRuleSet implements IteratorAggregate
{
    private array $rules;

    public function __construct(array $rules)
    {
        if ($rules === []) {
            throw new InvalidArgumentException('Document validation rules list is emtpy.');
        }

        foreach ($rules as $rule) {
            if (!$rule instanceof DocumentValidationRule) {
                throw new InvalidArgumentException('Rule must implement DocumentValidationRule contract.');
            }
        }

        $this->rules = $rules;
    }

    public function getIterator(): Traversable
    {
        yield from $this->rules;
    }
}
