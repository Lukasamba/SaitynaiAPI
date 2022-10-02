<?php

namespace App\Helpers\Validation;

class CommonRequestValidationRules
{
    const REQUIRED = [
        'required',
    ];

    const STRING_OPTIONAL = [
        'string',
        'nullable',
        'max:255',
    ];

    const STRING_REQUIRED = [
        'required',
        'string',
        'max:255',
    ];

    const NUMERIC_REQUIRED = [
        'required',
        'numeric',
    ];

    const ARRAY_REQUIRED = [
        'required',
        'array',
    ];

    const ARRAY_OPTIONAL = [
        'array',
        'nullable',
    ];
}
