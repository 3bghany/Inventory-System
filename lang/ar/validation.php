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

    'confirmed' => ' يجب ان يتم تأكيد :attribute .',
    'current_password' => ' password is incorrect.',
    'date' => 'يجب ان يكون بالشكل "xx/xx/xxxx"',
    'digits' => 'يجب ان يتكون :attribute من :digits رقم',
    'email' => 'يجب ان يكون :attribute بالشكل "example@gmail.com ".',

    'integer' => 'يجب ان يكون :attribute ارقاماً صحيحة',

    // 'max' => [
    //     'array' => ' :attribute حقل يجب not have more than :max items.',
    //     'file' => ' :attribute حقل يجب not be greater than :max kilobytes.',
    //     'numeric' => ' :attribute حقل يجب not be greater than :max.',
    //     'string' => ' :attribute حقل يجب not be greater than :max characters.',
    // ],
    // 'mimes' => ' :attribute حقل يجب be a file of type: :values.',
    // 'mimetypes' => ' :attribute حقل يجب be a file of type: :values.',
    // 'min' => [
    //     'array' => ' :attribute حقل يجب have at least :min items.',
    //     'file' => ' :attribute حقل يجب be at least :min kilobytes.',
    //     'numeric' => ' :attribute حقل يجب be at least :min.',
    //     'string' => ' :attribute حقل يجب be at least :min characters.',
    // ],
    'numeric' => 'يجب ان يكون :attribute ارقاماً',

    'required' => 'حقل :attribute مطلوب',

    'same' => 'يجب ان يساوي :attribute :other.',
    'string' => 'يجب ان يكون :attribute حروف',
    'unique' => 'لقد تم اخذ هذا :attribute من قبل',

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
        'supplier_id.required' => 'اختر احد الموردين',
        'category_id.required' => 'اختر واحدة من الفئات',
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
        'name'=>'الاسم',
        'email'=>'البريد إلكتروني',
        'address'=>'العنوان',
        'salary'=>'المرتب',
        'phone'=>'الهاتف',
        'photo'=>'الصورة',
        'nid'=>'الرقم القومي',
        'joining_date'=>'تاريخ الانضمام',
        'shopname'=>'اسم المحل',
        'salary_month'=>'راتب الشهر',
        'category_id'=>'رقم الفئة',
        'supplier_id'=>'رقم المورد',
        'code'=>'الرمز',
        'root'=>'الاصل',
        'buying_price'=>'سعر الشراء',
        'selling_price'=>'سعر البيع',
        'buying_date'=>'تاريخ الشراء',
        'quantity'=>'الكمية',
        'details'=>'التفاصيل',
        'amount'=>'الكمية',
        'password'=>'كلمة المرور',
        'OTP'=>'كلمة السر لمرة واحدة',
    ],

];
