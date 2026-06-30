<?php

declare(strict_types=1);

namespace App\Data;

use App\Exceptions\TenantMismatchException;
use App\Model\Document;
use App\Model\Tenant;
use App\Values\DocumentValidationRuleSet;

final readonly class DocumentValidationRequest
{
    public function __construct(
        public Tenant $tenant,
        public Document $document,
        private DocumentValidationRuleSet $rules,
    ) {
        if ($tenant->id !== $document->tenantId) {
            throw TenantMismatchException::forDocument(
                documentId: $document->id,
                expectedTenantId: $tenant->id,
                actualTenantId: $document->tenantId,
            );
        }
    }

    public function rules(): DocumentValidationRuleSet
    {
        return $this->rules;
    }
}
