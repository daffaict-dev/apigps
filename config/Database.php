<?php

class Database {
    private $host = "mysql-daffaiotdev.alwaysdata.net";
    private $user = "440761";
    private $pass = "Daffa123*";
    private $dbname = "daffaiotdev_daffagps"; 

    public $conn;

    public function connect() {
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            if ($this->conn->connect_error) {
                throw new Exception("DB Connection failed: " . $this->conn->connect_error);
            }

            return $this->conn;

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            exit;
        }
    }
}
