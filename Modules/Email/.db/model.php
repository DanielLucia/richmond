<?php

return [
    'forms' => [],
    'database' => [
        [
            'table' => 'emails',
            'primary' => 'id',
            'fields' => [
                'id' => 'INT',
                'uid' => 'INT',
                'account_email' => 'INT',
                'user_id' => 'INT',
                'seen' => 'INT',
                'id_email' => 'VARCHAR (150)',
                'title' => 'VARCHAR (200)',
                'email_from' => 'VARCHAR (100)',
                'email_to' => 'VARCHAR (100)',
                'body' => 'TEXT',
                'mailbox' => 'VARCHAR (100)',
                'date' => 'DATETIME',
                'created_at' => 'DATETIME',
                'updated_at' => 'DATETIME',
            ]
        ],
        [
            'table' => 'emails_accounts',
            'primary' => 'id',
            'fields' => [
                'id' => 'INT',
                'user_id' => 'INT',
                'host' => 'VARCHAR (150)',
                'account' => 'VARCHAR (200)',
                'password' => 'VARCHAR (100)',
                'port' => 'INT',
                'ssl' => 'INT',
                'created_at' => 'DATETIME',
                'updated_at' => 'DATETIME',
            ]
        ],
        [
            'table' => 'emails_mailboxes',
            'primary' => 'id',
            'fields' => [
                'id' => 'INT',
                'user_id' => 'INT',
                'email_account' => 'INT',
                'title' => 'VARCHAR (200)',
                'created_at' => 'DATETIME',
                'updated_at' => 'DATETIME',
            ]
        ],
    ]
];
