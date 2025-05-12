<?php

namespace App\models;

use PDO;

class SqlConnect {
    public object $db;
    private string $host;
    private string $port;
    private string $dbname;
    private string $password;
    private string $user;

    public function __construct() {
        $this->host = $_ENV['BDD_URL'];
        $this->port = $_ENV['BDD_PORT'];
        $this->dbname = $_ENV['BDD_NAME'];
        $this->user = $_ENV['BDD_USERNAME'];
        $this->password = $_ENV['BDD_PASSWORD'];

        $this->db = new PDO(
            'mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
            $this->user,
            $this->password
        );

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_PERSISTENT, false);
    }

    public function transformDataInDot($data) {
        $dataFormated = [];

        foreach ($data as $key => $value) {
            $dataFormated[':' . $key] = $value;
        }

        return $dataFormated;
    }
}