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
            switch ($this->connectionType) {
                case 'sqlite':
                    return $this->sqliteConnection();
                break;

                case 'mysql':
                    return $this->mysqlConnection();
                break;

                default:
                    return $this->sqliteConnection();
            }

        } catch (\PDOException $exception) {
            return [
                "success" => false,
                "error" => $exception->getMessage(),
                "message" => "Failed to connect to the database. Please check your database configuration.",
                "data" => [
                    "exception" => $exception->getMessage(),
                ]
            ]
        }
    }

    private function sqliteConnection()
    {
        if (empty($this->path)) {
            $this->path = __DIR__ . DIRECTORY_SEPARATOR .  join(DIRECTORY_SEPARATOR, ['..', '..', '..', '']);
        }

        $this->conn = new \PDO("sqlite:$this->path$this->db_name$this->extension");
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        if (!file_exists("$this->path$this->db_name$this->extension")) {
            $this->conn->exec("CREATE DATABASE $this->db_name");
        }

        return $this->conn;
    }

    private function mysqlConnection()
    {
        $this->conn = new \PDO("mysql:host=$this->host;port=$this->port;dbname=$this->db_name", $this->username, $this->password);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $this->conn;
    }
}
