<?php

final class Repositiry {

    private static ?Repositiry $repo = null;

    public int $num = 0;

    private ?PDO $pdo = null;

    private function __construct(
        private $servername,
        private $username,
        private $password,
        private $dbname
    )
    {
        try {

            $this->pdo = new \PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

        } catch (PDOException $e) {

            file_put_contents('./mysql.log', $e->getMessage() . "\n", FILE_APPEND);

        }
    }

    public static function getRepository(
        $servername,
        $username,
        $password,
        $dbname
    )
    {
        if(static::$repo) {
            return static::$repo;
        } else {
            static::$repo = new Repositiry(
                $servername,
                $username,
                $password,
                $dbname
            );
        }

        return static::$repo;
    }

    private function query($query, $params = []) {

        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => $value) {

            $data[$key] = htmlspecialchars($value);

        }

        $stmt->execute($params);

        return $stmt;
    }

    public function fetchAll($query, $params = []) {

        $stmt = $this->query($query, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function fetch($query, $params = []) {

        $stmt = $this->query($query, $params);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public function insert($table, $data) {

        $columns = implode(", ", array_keys($data));

        $values = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        $this->query($query, $data);

    }

    public function update($table, $data, $where) {

        $set = "";

        $params = [];

        foreach ($data as $key => $value) {

            $set .= "$key = :$key, ";

            $params[":$key"] = $value;

        }

        $set = rtrim($set, ", ");

        $query = "UPDATE $table SET $set WHERE $where";

        $this->query($query, $params);

    }

    public function delete($table, $where) {

        $query = "DELETE FROM $table WHERE $where";

        $this->query($query);

    }

}