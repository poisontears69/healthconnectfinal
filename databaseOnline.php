<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'healthconnectfinal';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }

    public function query($sql, $params = []) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function insert($sql, $params = []) {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $this->getConnection()->lastInsertId();
    }

    public function update($sql, $params = []) {
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($sql, $params = []) {
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($params);
    }
}
?>