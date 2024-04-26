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
            'method_not_allowed' => 'Método não permitido.',
            'fail_retrieving_data' => 'Falha ao recuperar dados.',
            'parameters_empty' => 'Parâmetros não podem ser vazios.',
        ],
        'users' => [
            'users_empty' => 'Por favor, preencha todos os campos.',
            'users_not_found' => 'Usuário não encontrado.',
            'users_not_activated' => 'Usuário não ativado.',
            'users_password_incorrect' => 'Senha incorreta.',
            'users_token_not_generated' => 'Token não gerado.',
            'users_passwords_dont_match' => 'As senhas não coincidem.',
            'users_invalid_email' => 'E-mail inválido.',
        ],
        'token' => [
            'token_not_found' => 'Token não encontrado.',
        ],
        'unit_converter' => [
            'converter_not_found' => 'Conversor não encontrado.',
            'not_implemented_yet' => 'Ainda não implementado.',
        ]
    ],
    'success' => [
        'users' => [
            'users_logged_in' => 'Usuário logado.',
            'user_registered' => 'Usuário registrado.',
            'user_updated' => 'Usuário atualizado.',
            'user_desactivated' => 'Usuário desativado.',
        ],
        'general' => [
            'data_retrieved' => 'Dados retornados com sucesso.',
        ]
    ],
    'return_keys' => [
        'success' => 'sucesso',
        'status' => 'status',
        'message' => 'mensagem',
        'data' => 'dados',
        'response_time' => 'tempo_de_resposta',
        'random_numbers' => [
            'numbers' => 'numeros',
            'statistic' => 'estatistica',
            'min_output' => 'saida_minima',
            'max_output' => 'saida_maxima',
            'average_output' => 'media',
            'data' => 'dados',
        ]
    ]
];