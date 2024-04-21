<?php

namespace App\Models;

use App\Utils\Database\Database;

class UserModel extends AbastractModel
{

    protected $table = "users";

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->getConnection();
        $this->createUserTable();
    }

    private function createUserTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            password TEXT NOT NULL,
            is_activated INTEGER DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            deleted_at TIMESTAMP DEFAULT NULL
        );";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }
}
