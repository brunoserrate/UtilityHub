<?php

/*
    Data Structure:
    [
        'purpose' => [
            'context' => [
                'key/code' => 'message',
            ]
        ],
    ]

    Example:
    [
        'error' => [
            'users' => [
                'users_empty' => 'Please fill all the fields.',
                'users_not_found' => 'User not found.',
                'users_not_activated' => 'User not activated.',
            ],
        ],
    ]

    Explenation:
     - purpose: The purpose of the message, for example: error, success, warning, general, etc.
        - context: The context of the message, for example: users, posts, comments, etc.
            - key/code: The key or code of the message, for example: users_empty, users_not_found, users_not_activated, etc.
                - message: The message itself, for example: Please fill all the fields, User not found, User not activated, etc.
*/
return [
    'error' => [
        'general' => [
            'method_not_allowed' => 'Method not allowed.',
            'fail_retrieving_data' => 'Fail retrieving data.',
            'parameters_empty' => 'Parameters cannot be empty.',
        ],
        'users' => [
            'users_empty' => 'Please fill all the fields.',
            'users_not_found' => 'User not found.',
            'users_not_activated' => 'User not activated.',
            'users_password_incorrect' => 'Password incorrect.',
            'users_token_not_generated' => 'Token not generated.',
            'users_passwords_dont_match' => 'Passwords don\'t match.',
            'users_invalid_email' => 'Invalid email.',
        ],
        'token' => [
            'token_not_found' => 'Token not found.',
        ],
        'unit_converter' => [
            'converter_not_found' => 'Converter not found.',
            'not_implemented_yet' => 'Not implemented yet.',
        ]
    ],
    'success' => [
        'users' => [
            'users_logged_in' => 'User logged in.',
            'user_registered' => 'User registered.',
            'user_updated' => 'User updated.',
            'user_desactivated' => 'User desactivated.',
        ],
        'general' => [
            'data_retrieved' => 'Data retrieved successfully.',
        ]
    ],
    'return_keys' => [
        'success' => 'success',
        'status' => 'status',
        'message' => 'message',
        'data' => 'data',
        'response_time' => 'response_time',
        'random_numbers' => [
            'numbers' => 'numbers',
            'statistic' => 'statistic',
            'min_output' => 'min_output',
            'max_output' => 'max_output',
            'average_output' => 'average_output',
            'data' => 'data',
        ]
    ],
];

