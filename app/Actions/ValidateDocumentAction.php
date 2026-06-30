<?php

declare(strict_types=1);

namespace App\Actions;

use App\Core\DocumentValidation\DocumentValidator;
use App\Data\DocumentValidationRequest;
use App\Values\DocumentValidationResult;

final class ValidateDocumentAction
{
    public function __construct(
        private DocumentValidator $validator,
    ) {
    }

    public function execute(DocumentValidationRequest $request): DocumentValidationResult
    {
        return $this->validator->validate($request->document, $request->rules());
    }
}
