<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\UserModel;

use App\Repositories\TokenRepository;

class UserRepository extends BaseRepository {
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function searchUser($input) {
        if(!isset($input['email']) || !isset($input['password'])) {
            return $this->sendError('Email e senha são obrigatórios', [], 400);
        }

        $user = $this->userModel->get(0, 1, 'id', 'ASC', ['*'], [
            [
                'key' => 'email',
                'operator' => '=',
                'value' => $input['email']
            ]
        ]);

        if($user['success'] && count($user['data']) == 0 ) {
            return $this->sendError('Usuário não encontrado', [], 404);
        }

        $user = $user['data'];

        if (count($user) > 0) {
            return $this->sendSuccess('Usuário encontrado', $user[0]);
        }

        return $this->sendError('Usuário não encontrado', [], 404);
    }

    public function verifyPassword($input, $user) {
        if(!password_verify($input['password'], $user['password'])) {
            return $this->sendError('Senha inválida', [], 400);
        }

        return $this->sendSuccess('Senha válida', []);
    }

    public function login($user) {
        $tokenRepository = new TokenRepository();

        $result = $tokenRepository->generateToken([
            'user_id' => $user['id']
        ]);

        if(!$result['success']) {
            return $this->sendError('Erro ao criar token', [], 400);
        }

        return $this->sendSuccess('Token criado', $result['data']);
    }

    public function store($input) {
        if(!isset($input['nome']) || !isset($input['email']) || !isset($input['password'])) {
            return $this->sendError('Nome, email e senha são obrigatórios', [], 400);
        }

        if($input['password'] != $input['confirm_password']) {
            return $this->sendError('Senhas não coincidem', [], 400);
        }

        $user = $this->userModel->get(0, 1, 'id', 'ASC', ['*'], [
            [
                'key' => 'email',
                'operator' => '=',
                'value' => $input['email']
            ]
        ]);

        if($user['success'] && count($user['data']) > 0) {
            return $this->sendError('Usuário já cadastrado', [], 400);
        }

        $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);

        $result = $this->userModel->insert([
            'name' => $input['nome'],
            'email' => $input['email'],
            'password' => $input['password']
        ]);

        if(!$result['success']) {
            return $this->sendError('Erro ao cadastrar usuário: ' . $result['message'], [], 400);
        }

        return $this->sendSuccess('Usuário cadastrado', []);
    }

}