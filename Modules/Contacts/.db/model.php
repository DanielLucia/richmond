<?php

return [
    'forms' => [],
    'database' => [
        [
            'table' => 'contacts',
            'primary' => 'id',
            'fields' => [
                'id' => 'INT',
                'user_id' => 'INT',
                'email' => 'VARCHAR (150)',
                'name' => 'VARCHAR (150)',
                'lastname' => 'VARCHAR (150)',
                'phone' => 'VARCHAR (12)',
                'created_at' => 'DATETIME',
                'updated_at' => 'DATETIME',
            ]
        ],

    ]
];
