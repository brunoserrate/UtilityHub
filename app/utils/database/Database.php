<?php

namespace App\Utils\Database;

use App\Utils\Helpers\EnvLoader;

class Database {
    private $connectionType = "sqlite";
    private $host = "localhost";
    private $port = "3306";
    private $username = "";
    private $password = "";
    private $path = __DIR__ . DIRECTORY_SEPARATOR .  '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
    private $db_name = "utility_hub_database";
    private $extension = ".sqlite";

    public $conn;

    public function __construct() {
        $env = EnvLoader::loadEnv();

        if (isset($env['DB_CONNECTION'])) {
            $this->connectionType = $env['DB_CONNECTION'];
        }

        if (isset($env['DB_PATH'])) {
            $this->path = $env['DB_PATH'];
        }

        if (isset($env['DB_DATABASE'])) {
            $this->db_name = $env['DB_DATABASE'];
        }

        if (isset($env['DB_EXTENSION'])) {
            $this->extension = $env['DB_EXTENSION'];
        }

        if (isset($env['DB_HOST'])) {
            $this->host = $env['DB_HOST'];
        }

        if (isset($env['DB_PORT'])) {
            $this->port = $env['DB_PORT'];
        }

        if (isset($env['DB_USERNAME'])) {
            $this->username = $env['DB_USERNAME'];
        }

        if (isset($env['DB_PASSWORD'])) {
            $this->password = $env['DB_PASSWORD'];
        }
    }

    public function getConnection()
    {

        try {
            if ($this->connectionType == "sqlite") {
                if (empty($this->path)) {
                    $this->path = __DIR__ . DIRECTORY_SEPARATOR .  '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
                }

                $this->conn = new \PDO("sqlite:$this->path$this->db_name$this->extension");
                $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

                if (!file_exists("$this->path$this->db_name$this->extension")) {
                    $this->conn->exec("CREATE DATABASE $this->db_name");
                }

                return $this->conn;
            }
        } catch (\PDOException $exception) {
            echo json_encode(array("error" => "Database connection error: " . $exception->getMessage()));
            die();
        }
    }
}
