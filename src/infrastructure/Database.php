<?php declare(strict_types=1);
namespace Infrastructure;

use PDO;
use PHPUnit\TextUI\XmlConfiguration\Exception;

class Database {
    private PDO $pdo;
    private string $db_name;
    public function __construct()
    {
        $host_name = getenv("DB_HOST");
        $user = getenv("DB_USER");
        $pass = getenv("DB_PASS");
        $this->db_name = 'aos_tracker';
        $data_source = "pgsql:host=$host_name;dbname=$this->db_name";

        $this->pdo = new PDO($data_source, $user, $pass);
    }

    public function connect():PDO {
        return $this->pdo;
    }

    public function getDbName() {
        return $this->db_name;
    }
}