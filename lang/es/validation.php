<?php
return [
    'required'  => 'El campo :attribute es obligatorio.',
    'string'    => 'El campo :attribute debe ser texto.',
    'max'       => ['string' => 'El campo :attribute no puede superar :max caracteres.'],
    'min'       => ['numeric' => 'El campo :attribute debe ser al menos :min.', 'string' => 'El campo :attribute debe tener al menos :min caracteres.'],
    'numeric'   => 'El campo :attribute debe ser un número.',
    'integer'   => 'El campo :attribute debe ser un número entero.',
    'image'     => 'El campo :attribute debe ser una imagen.',
    'mimes'     => 'El campo :attribute debe ser de tipo: :values.',
    'unique'    => 'El :attribute ya está en uso.',
    'email'     => 'El campo :attribute debe ser un email válido.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'attributes' => [
        'title'       => 'título',
        'description' => 'descripción',
        'base_price'  => 'precio base',
        'end_time'    => 'fecha de cierre',
        'category_id' => 'categoría',
        'condition'   => 'condición',
        'image'       => 'imagen',
    ],
];
