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

            file_put_contents('./mysql.log', $e->getMessage(), FILE_APPEND);

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
}