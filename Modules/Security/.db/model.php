<?php

return [
    'forms' => [],
    'database' => [
        [
            'table' => 'connections',
            'primary' => 'id',
            'fields' => [
                'id' => 'INT',
                'user_id' => 'INT',
                'banned' => 'INT',
                'logged' => 'INT',
                'ip' => 'VARCHAR (15)',
                'hostname' => 'VARCHAR (255)',
                'org' => 'VARCHAR (255)', 
                'agent' => 'VARCHAR (255)',
                'location' => 'VARCHAR (255)',
                'created_at' => 'DATETIME',
                'updated_at' => 'DATETIME',
            ]
        ],
    ]
];
