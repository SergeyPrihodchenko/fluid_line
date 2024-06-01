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

    public function set(string $data)
    {

        $validated = htmlspecialchars($data);

        $query = <<<SQL
            INSERT INTO table (data) VALUE (:data);
        SQL;

        $statment = $this->pdo->prepare($query);
        
        $statment->bindParam(':data', $validated);

        $statment->execute();

    }

    public function update(int $id, string $data)
    {

        $validated = htmlspecialchars($data);

        $query = <<<SQL
            UPDATE table SET data = :data WHERE id = :id
        SQL;

        $statment = $this->pdo->prepare($query);


        $statment->bindParam(':id', $id);
        $statment->bindParam(':data', $validated);

        $statment->execute();
    }

    public function delete()
    {
        $query = <<<SQL
            DELETE FROM table WHERE id = :id
        SQL;

        $statment = $this->pdo->prepare($query);

        $statment->bindParam(':id', $id);

        $statment->execute();
    }

    public function getAll(string $table): array
    {
        $query = <<<SQL
            SELECT * FROM $table;
        SQL;

        $statment = $this->pdo->prepare($query);

        $statment->execute();

        $result = $statment->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


}