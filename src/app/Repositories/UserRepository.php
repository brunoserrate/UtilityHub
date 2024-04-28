<?php
namespace App\Repositories;

use App\Models\UserModel;

class UserRepository {
    protected $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function searchUser($input) {
        if(!isset($input['email']) || !isset($input['password'])) {
            return false;
        }

        $user = $this->userModel->get(0, 1, 'id', 'ASC', ['*'], [
            [
                'key' => 'email',
                'operator' => '=',
                'value' => $input['email']
            ]
        ]);

        if (count($user) > 0) {
            return $user[0];
        }

        return false;
    }

}