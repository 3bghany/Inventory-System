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

    'confirmed' => 'La conferma del campo :attribute non corrisponde.',
    'current_password' => 'La password non è corretta.',
    'date' => 'Il campo :attribute deve essere una data valida.',
    'digits' => 'Il campo :attribute deve essere :digits cifre.',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido.',

    'integer' => 'Il campo :attribute deve essere un numero intero.',

    'max' => [
        'array' => 'Il campo :attribute non deve contenere più di :max elementi.',
        'file' => 'Il campo :attribute non deve essere maggiore di :max kilobyte.',
        'numeric' => 'Il campo :attribute non deve essere maggiore di :max.',
        'string' => 'Il campo :attribute non deve essere maggiore di :max caratteri.',
    ],
    'mimes' => 'Il campo :attribute deve essere un file di tipo: :values.',
    'mimetypes' => 'Il campo :attribute deve essere un file di tipo: :values.',
    'min' => [
        'array' => 'Il campo :attribute deve contenere almeno :min elementi.',
        'file' => 'Il campo :attribute deve essere almeno :min kilobyte.',
        'numeric' => 'Il campo :attribute deve essere almeno :min.',
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
    ],
    'numeric' => 'Il campo :attribute deve essere un numero.',
    'password' => [
        'letters' => 'Il campo :attribute deve contenere almeno una lettera.',
        'mixed' => 'Il campo :attribute deve contenere almeno una lettera maiuscola e una minuscola.',
        'numbers' => 'Il campo :attribute deve contenere almeno un numero.',
        'symbols' => 'Il campo :attribute deve contenere almeno un simbolo.',
        'uncompromised' => 'Il dato :attribute è apparso in una fuga di dati. Scegli un :attribute diverso.',
    ],
    'required' => 'Il campo :attribute è obbligatorio.',

    'same' => 'Il campo :attribute deve corrispondere a :other.',
    'string' => 'Il campo :attribute deve essere una stringa.',
    'unique' => 'L\' :attribute è già stato preso.',
 
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
        'supplier_id.required' => 'Scegli uno dei Fornitori',
        'category_id.required' => 'Scegli una delle Categorie',
        'password.regex' => 'la password deve contenere (Uppercase,Lowercase,numbers).Simboli consentiti( _ - ! @ # )',

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

    'attributes' => [
        'name'=>'nome',
        'email'=>'email',
        'address'=>'indirizzo',
        'salary'=>'stipendio',
        'phone'=>'telefono',
        'photo'=>'foto',
        'nid'=>'nid',
        'joining_date'=>'data_di_iscrizione',
        'shopname'=>'nomenegozio',
        'salary_month'=>'stipendio_mese',
        'category_id'=>'ID_categoria',
        'supplier_id'=>'fornitore_id',
        'code'=>'codice',
        'root'=>'radice',
        'buying_price'=>'prezzo_acquisto',
        'selling_price'=>'prezzo di vendita',
        'buying_date'=>'data_acquisto',
        'quantity'=>'quantità',
        'details'=>'dettagli',
        'amount'=>'quantità',
        'password'=>'parola d\'ordine',
        'OTP'=>'OTP',
    ],

];
