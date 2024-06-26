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
}
