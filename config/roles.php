<?php

return [
    'roles' => ['Admin', 'Tecnico', 'Consulta'],

    'permisos' => [
        'Admin' => [
            'descripcion' => 'Acceso total al sistema',
            'mutar' => true,
            'admin' => true,
        ],
        'Tecnico' => [
            'descripcion' => 'Operaciones de campo',
            'mutar' => true,
            'admin' => false,
        ],
        'Consulta' => [
            'descripcion' => 'Solo lectura',
            'mutar' => false,
            'admin' => false,
        ],
    ],

    'middleware_roles' => [
        'admin' => ['Admin'],
        'tecnico' => ['Admin', 'Tecnico'],
        'cualquiera' => ['Admin', 'Tecnico', 'Consulta'],
    ],
];
