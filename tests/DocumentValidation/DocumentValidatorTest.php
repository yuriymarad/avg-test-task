<?php

declare(strict_types=1);

use App\Core\DocumentValidation\Rules\MaximumDocumentSizeRule;
use App\Core\DocumentValidation\Rules\ProhibitedWordsRule;
use App\Core\DocumentValidation\Rules\RequiredMetadataFieldsRule;
use App\Values\DocumentValidationRuleSet;

test('Success if document pass all rules', function () {
    $document = makeDocument('test doc content', metadata: ['country' => 'USA']);

    $result = makeDocumentValidator()->validate(
        $document, 
        new DocumentValidationRuleSet([
            new MaximumDocumentSizeRule(maxBytes: 1000),
            new RequiredMetadataFieldsRule(['country']),
            new ProhibitedWordsRule(['password']),
        ]),
    );

    expect($result->isValid())->toBeTrue()
        ->and($result->errors())->toBe([]);
});

test('Error if rule set is empty', function () {
    expect(fn () => new DocumentValidationRuleSet([]))
        ->toThrow(InvalidArgumentException::class);
});

test('Error if rule set item is not related to class contract', function () {
    expect(fn () => new DocumentValidationRuleSet([new stdClass()]))
        ->toThrow(InvalidArgumentException::class);
});

test('Check if all violitions are agregated in result object', function () {
    $document = makeDocument('this is a long doc with a password leak', metadata: []);

    $result = makeDocumentValidator()->validate(
        $document, 
        new DocumentValidationRuleSet([
            new MaximumDocumentSizeRule(maxBytes: 5),
            new RequiredMetadataFieldsRule(['country']),
            new ProhibitedWordsRule(['password']),
        ])
    );

    expect($result->isValid())->toBeFalse()
        ->and($result->errors())->toHaveCount(3);
});