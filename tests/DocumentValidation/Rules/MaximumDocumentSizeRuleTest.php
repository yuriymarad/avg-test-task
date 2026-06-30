<?php

declare(strict_types=1);

use App\Core\DocumentValidation\Rules\MaximumDocumentSizeRule;

test('Success if document size is less than setted max size', function () {
    $document = makeDocument('small content file');

    $violations = (new MaximumDocumentSizeRule(maxBytes: 1000))
        ->validate($document);

    expect($violations)->toBe([]);
});

test('Success if document size is equal to max size', function () {
    $document = makeDocument('test content');

    $violations = (new MaximumDocumentSizeRule(maxBytes: 12))
        ->validate($document);

    expect($violations)->toBe([]);
});

test('Error if document size is greater than max size', function () {
    $document = makeDocument('very big document content');

    $violations = (new MaximumDocumentSizeRule(maxBytes: 5))
        ->validate($document);

    expect($violations)->toHaveCount(1)
        ->and($violations[0]->message)->toBe('Document size 25 exceeds maximum limit.');
});

test('Error if max size param is negative', function () {
    expect(fn () => new MaximumDocumentSizeRule(maxBytes: -1))
        ->toThrow(InvalidArgumentException::class);
});

test('Error if max size param is zero', function () {
    expect(fn () => new MaximumDocumentSizeRule(maxBytes: 0))
        ->toThrow(InvalidArgumentException::class);
});