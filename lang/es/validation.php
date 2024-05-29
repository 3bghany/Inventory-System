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

    'confirmed' => 'La confirmación del campo de :attribute no coincide.',
    'current_password' => 'La contraseña es incorrecta.',
    'date' => 'El campo de :attribute debe ser una fecha válida.',
    'digits' => 'El campo de :attribute debe tener 11 dígitos.',
    'email' => 'El campo de :attribute debe ser una dirección de correo electrónico válida.',

    'integer' => 'El campo de :attribute debe ser un número entero.',

    // 'max' => [
    //     'array' => 'The attribute field must not have more than :max items.',
    //     'file' => 'The attribute field must not be greater than :max kilobytes.',
    //     'numeric' => 'The attribute field must not be greater than :max.',
    //     'string' => 'The attribute field must not be greater than :max characters.',
    // ],
    // 'mimes' => 'The attribute field must be a file of type: :values.',
    // 'mimetypes' => 'The attribute field must be a file of type: :values.',
    // 'min' => [
    //     'array' => 'The attribute field must have at least :min items.',
    //     'file' => 'The attribute field must be at least :min kilobytes.',
    //     'numeric' => 'The attribute field must be at least :min.',
    //     'string' => 'The attribute field must be at least :min characters.',
    // ],
    'numeric' => 'El campo de :attribute debe ser un número.',
    // 'password' => [
    //     'letters' => 'The :attribute field must contain at least one letter.',
    //     'mixed' => 'The attribute field must contain at least one uppercase and one lowercase letter.',
    //     'numbers' => 'The attribute field must contain at least one number.',
    //     'symbols' => 'The attribute field must contain at least one symbol.',
    //     'uncompromised' => 'The given attribute has appeared in a data leak. Please choose a different attribute.',
    // ],
    'required' => 'El campo de :attribute es obligatorio.',

    'same' => 'El campo del :attribute debe coincidir con :other.',
    'string' => 'El campo de :attribute debe ser una cadena.',
    'unique' => 'El :attribute ya ha sido tomado.',

    





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
        // 'supplier_id.required' => 'Elija uno de los proveedores',
        'supplier_id.required' => 'Elija uno de los proveedores',
        'category_id.required' => 'Elija una de las categorías',
        'password.regex' => 'la contraseña debe contener (Uppercase,Lowercase,numbers).Símbolos permitidos( _ - ! @ # )',

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
        'name'=>'nombre',
        'email'=>'correo electrónico',
        'address'=>'DIRECCIÓN',
        'salary'=>'salario',
        'phone'=>'teléfono',
        'photo'=>'foto',
        'nid'=>'nid',
        'joining_date'=>'dia de ingreso',
        'shopname'=>'Nombre de tienda',
        'salary_month'=>'salario_mes',
        'category_id'=>'categoria ID',
        'supplier_id'=>'Identificación del proveedor',
        'code'=>'código',
        'root'=>'raíz',
        'buying_price'=>'precio de compra',
        'selling_price'=>'precio de venta',
        'buying_date'=>'fecha_de_compra',
        'quantity'=>'cantidad',
        'details'=>'detalles',
        'amount'=>'cantidad',
        'password'=>'contraseña',
        'OTP'=>'OTP',
    ],

];
