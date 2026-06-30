<?php

declare(strict_types=1);

use App\Actions\ValidateDocumentAction;
use App\Core\DocumentValidation\DocumentValidator;
use App\Data\DocumentValidationRequest;
use App\Core\DocumentValidation\Rules\MaximumDocumentSizeRule;
use App\Core\DocumentValidation\Rules\ProhibitedWordsRule;
use App\Core\DocumentValidation\Rules\RequiredMetadataFieldsRule;
use App\Model\Document;
use App\Model\Tenant;
use App\Values\DocumentValidationRuleSet;

require __DIR__ . '/vendor/autoload.php';

// 1. Valid document check
$validateAction = new ValidateDocumentAction(new DocumentValidator());

$tenant = new Tenant(id: 'tenant-001');

$document = new Document(
    id: 'doc-001',
    tenantId: $tenant->id,
    content: 'Summary report for financial team',
    metadata: ['date' => '2026-06-10', 'country' => 'USA'],
);

$request = new DocumentValidationRequest(
    $tenant,
    $document,
    new DocumentValidationRuleSet([
        new MaximumDocumentSizeRule(maxBytes: 64),
        new RequiredMetadataFieldsRule(['date', 'country']),
        new ProhibitedWordsRule(['password', 'key']),
    ]),
);

$result = $validateAction->execute($request);

printf("=== Valid document === \n");
printf('isValid = %s%s', $result->isValid() ? 'true' : 'false', PHP_EOL);

// 2. Invalid document check
$invalidDocument = new Document(
    id: 'doc-002',
    tenantId: $tenant->id,
    content: 'Summary report for financial team that is very long to fit inside the size limit with accidental password leak',
    metadata: ['date' => '2026-06-10'],
);

$result = new DocumentValidationRequest(
    $tenant,
    $invalidDocument,
    new DocumentValidationRuleSet([
        new MaximumDocumentSizeRule(maxBytes: 64),
        new RequiredMetadataFieldsRule(['date', 'country']),
        new ProhibitedWordsRule(['password', 'key']),
    ]),
);

$result = $validateAction->execute($result);

printf("=== Invalid document === \n");
printf('isValid = %s%s', $result->isValid() ? 'true' : 'false', PHP_EOL);

foreach ($result->errors() as $violation) {
    printf(' - %s%s', $violation->message, PHP_EOL);
}

