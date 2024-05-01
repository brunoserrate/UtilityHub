<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\TokenModel;

class TokenRepository extends BaseRepository {
    protected $tokenModel;

    public function __construct() {
        $this->tokenModel = new TokenModel();
    }

    public function generateToken($input) {
        if(!isset($input['user_id'])) {
            return $this->sendError(__('Usuário é obrigatórios'), [], 400);
        }

        $token = bin2hex(random_bytes(64));

        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 day'));

        $token = $this->tokenModel->insert([
            'user_id' => $input['user_id'],
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        if($token['success']) {
            return $this->sendError(__('Erro ao criar token'), [], 400);
        }

        return $this->sendSuccess(__('Token criado'), $token['data']);
    }

    public function verifyToken($input) {
        if(!isset($input['token']) || !isset($input['user_id'])) {
            return $this->sendError(__('Token e usuário são obrigatórios'), [], 400);
        }

        $token = $this->tokenModel->get(0, 1, 'id', 'ASC', ['*'], [
            [
                'key' => 'token',
                'operator' => '=',
                'value' => $input['token']
            ],
            [
                'key' => 'user_id',
                'operator' => '=',
                'value' => $input['user_id']
            ],
            [
                'key' => 'expires_at',
                'operator' => '>',
                'value' => date('Y-m-d H:i:s')
            ]
        ]);

        if($token['success']) {
            return $this->sendError(__('Token inválido'), [], 400);
        }

        return $this->sendSuccess(__('Token válido'), $token['data'][0]);
    }

    public function deleteToken($input) {
        if(!isset($input['token'])) {
            return $this->sendError(__('Token é obrigatório'), [], 400);
        }

        $token = $this->tokenModel->delete([
            [
                'key' => 'token',
                'operator' => '=',
                'value' => $input['token']
            ]
        ]);

        if($token['success']) {
            return $this->sendError(__('Erro ao deletar token'), [], 400);
        }

        return $this->sendSuccess(__('Token deletado'), []);
    }

}