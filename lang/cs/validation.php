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

    'accepted' => 'Atribut :attribute musí být akceptován.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'Atribut :attribute není validní URL.',
    'after' => 'Atribut :attribute musí být datum po :date.',
    'after_or_equal' => 'Atribut :attribute musí být datum po nebo roven :date.',
    'alpha' => 'Atribut :attribute musí obsahovat jen písmena.',
    'alpha_dash' => 'Atribut :attribute musí obsahovat jen písmena, číslice, pomlčky and podtržítka.',
    'alpha_num' => 'Atribut :attribute musí obsahovat jen písmena and číslice.',
    'array' => 'Atribut :attribute musí být typu pole.',
    'before' => 'Atribut :attribute musí být datum před :date.',
    'before_or_equal' => 'Atribut :attribute musí být datum před nebo roven :date.',
    'between' => [
        'array' => 'Atribut :attribute musí být mezi hodnotami :min and :max.',
        'file' => 'Atribut :attribute musí mít velikost mezi :min and :max kilobytes.',
        'numeric' => 'Atribut :attribute musí být mezi hodnotami :min and :max.',
        'string' => 'Atribut :attribute musí mít délku mezi :min and :max znaky.',
    ],
    'boolean' => 'Atribut :attribute musí být true or false.',
    'confirmed' => 'Potvrzení atributu :attribute není správné.',
    'current_password' => 'Heslo není správné.',
    'date' => 'Atribut :attribute není validní datum.',
    'date_equals' => 'Atribut :attribute musí být datum roven :date.',
    'date_format' => 'Atribut :attribute neodpovídá formátu: :format.',
    'declined' => 'Atribut :attribute musí být odmítnut.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'Atributy :attribute a :other musí být různé.',
    'digits' => 'Atribut :attribute musí obsahovat :digits číslic.',
    'digits_between' => 'Atribut :attribute musí obsahovat od :min do :max číslic.',
    'dimensions' => 'Atribut :attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole atributu :attribute má duplicitní hodnotu.',
    'email' => 'Atribut :attribute musí být validní emailová adresa.',
    'ends_with' => 'Atribut :attribute musí končit jednou z následujících hodnot: :values.',
    'enum' => 'Vybraný atribut :attribute není validní.',
    'exists' => 'Vybraný atribut :attribute není validní.',
    'file' => 'Atribut :attribute musí být typu soubor.',
    'filled' => 'Pole atributu :attribute musí obsahovat hodnotu.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
    ],
    'image' => 'Atribut :attribute musí být typu obrázek.',
    'in' => 'Atribut :attribute je nevalidní.',
    'in_array' => 'Atribut :attribute neexistuje v :other.',
    'integer' => 'Atribut :attribute musí být typu integer.',
    'ip' => 'Atribut :attribute musí být validní IP adresa.',
    'ipv4' => 'Atribut :attribute musí být validní IPv4 adresa.',
    'ipv6' => 'Atribut :attribute musí být validní IPv6 adresa.',
    'json' => 'Atribut :attribute musí být validní typu JSON.',
    'lt' => [
        'array' => 'The :attribute must have less than :value items.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'numeric' => 'The :attribute must be less than :value.',
        'string' => 'The :attribute must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute must not have more than :value items.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
    ],
    'mac_address' => 'Atribut :attribute musí být validní MAC adresa.',
    'max' => [
        'array' => 'Atribut :attribute nesmí obsahovat více než :max prvků.',
        'file' => 'Atribut :attribute nesmí být větší than :max kilobytes.',
        'numeric' => 'Atribut :attribute nesmí být větší než :max.',
        'string' => 'Atribut :attribute nesmí být větší než :max znaků.',
    ],
    'mimes' => 'Atribut :attribute musí být soubor typu: :values.',
    'mimetypes' => 'Atribut :attribute musí být soubor typu: :values.',
    'min' => [
        'array' => 'Atribut :attribute musí mít alespoň :min prvků.',
        'file' => 'Atribut :attribute musí mít alespoň :min kilobytes.',
        'numeric' => 'Atribut :attribute musí být minimálně :min.',
        'string' => 'Atribut :attribute musí mít alespoň :min znaků.',
    ],
    'multiple_of' => 'Atribut :attribute musí být násobkem čísla :value.',
    'not_in' => 'Vybraný atribut :attribute je nevalidní.',
    'not_regex' => 'Formát atributu :attribute není validní.',
    'numeric' => 'Atribut :attribute musí být typu číslo.',
    'password' => 'Zadané heslo není správné.',
    'present' => 'Hodnota atributu :attribute musí být přítomná.',
    'prohibited' => 'Pole atributu :attribute je zakázané.',
    'prohibited_if' => 'Atribut :attribute je zakázaný když :other je :value.',
    'prohibited_unless' => 'Atribut :attribute je zakázaný pokud :other není :values.',
    'prohibits' => 'Atribut :attribute zakazuje atributům :other být přítomné.',
    'regex' => 'Formát atributu :attribute není validní.',
    'required' => 'Atribut :attribute je povinný.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'Atributy :attribute a :other se musí shodovat.',
    'size' => [
        'array' => 'Atribut :attribute musí obsahovat :size položek.',
        'file' => 'Soubor :attribute musí mít :size kilobytes.',
        'numeric' => 'Atribut :attribute musí být :size.',
        'string' => 'Atribut :attribute musí mít :size znaků.',
    ],
    'starts_with' => 'Atribut :attribute musí začínat jednou z následujících hodnot: :values.',
    'string' => 'Atribut :attribute musí být typu string.',
    'timezone' => 'Atribut :attribute musí být validní časová zóna.',
    'unique' => 'Atribut :attribute byl již použit.',
    'uploaded' => 'Upload souboru :attribute selhal.',
    'url' => 'Atribut :attribute musí být validní URL.',
    'uuid' => 'Atribut :attribute musí být validní UUID.',

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
