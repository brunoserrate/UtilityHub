<?php

namespace App\Models;

use App\Utils\Database\Database;

class TokenModel extends AbastractModel
{

    protected $table = "tokens";

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->getConnection();
        $this->createTokenTable();
    }

    private function createTokenTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS tokens (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            token TEXT NOT NULL,
            expires_at TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function generateToken($userId) {
        $token = bin2hex(random_bytes(64));

        $this->insert(
            [
                'user_id' => $userId,
                'token' => $token,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+2 hours'))
            ]
        );

        return $token;
    }
}
