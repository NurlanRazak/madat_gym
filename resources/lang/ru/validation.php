<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Поле :attribute must be accepted.',
    'active_url' => 'Поле :attribute is not a valid URL.',
    'after' => 'Поле :attribute must be a date after :date.',
    'after_or_equal' => 'Поле :attribute must be a date after or equal to :date.',
    'alpha' => 'Поле :attribute may only contain letters.',
    'alpha_dash' => 'Поле :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Поле :attribute may only contain letters and numbers.',
    'array' => 'Поле :attribute must be an array.',
    'before' => 'Поле :attribute must be a date before :date.',
    'before_or_equal' => 'Поле :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'Поле :attribute must be between :min and :max.',
        'file' => 'Поле :attribute must be between :min and :max kilobytes.',
        'string' => 'Поле :attribute must be between :min and :max characters.',
        'array' => 'Поле :attribute must have between :min and :max items.',
    ],
    'boolean' => 'Поле :attribute field must be true or false.',
    'confirmed' => 'Поле :attribute confirmation does not match.',
    'date' => 'Поле :attribute is not a valid date.',
    'date_equals' => 'Поле :attribute must be a date equal to :date.',
    'date_format' => 'Поле :attribute does not match the format :format.',
    'different' => 'Поле :attribute and :other must be different.',
    'digits' => 'Поле :attribute must be :digits digits.',
    'digits_between' => 'Поле :attribute must be between :min and :max digits.',
    'dimensions' => 'Поле :attribute has invalid image dimensions.',
    'distinct' => 'Поле :attribute field has a duplicate value.',
    'email' => 'Поле :attribute must be a valid email address.',
    'exists' => 'Поле selected :attribute is invalid.',
    'file' => 'Поле :attribute must be a file.',
    'filled' => 'Поле :attribute field must have a value.',
    'gt' => [
        'numeric' => 'Поле :attribute must be greater than :value.',
        'file' => 'Поле :attribute must be greater than :value kilobytes.',
        'string' => 'Поле :attribute must be greater than :value characters.',
        'array' => 'Поле :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'Поле selected :attribute is invalid.',
    'not_regex' => 'Поле :attribute format is invalid.',
    'numeric' => 'Поле :attribute must be a number.',
    'present' => 'Поле :attribute field must be present.',
    'regex' => 'Поле :attribute format is invalid.',
    'required' => 'Это поле обязательное для заполнения.',
    'required_if' => 'Поле :attribute field is required when :other is :value.',
    'required_unless' => 'Поле :attribute field is required unless :other is in :values.',
    'required_with' => 'Поле :attribute field is required when :values is present.',
    'required_with_all' => 'Поле :attribute field is required when :values are present.',
    'required_without' => 'Поле :attribute field is required when :values is not present.',
    'required_without_all' => 'Поле :attribute field is required when none of :values are present.',
    'same' => 'Поле :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
