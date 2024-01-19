<?php

require "config.php";

class Database
{
    private string $host = '';
    private string $user = '';
    private string $password = '';
    private string $dbname = '';
    public PDO $connection;

    public function __construct(string $host, string $user, string $password, string $dbname)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbname = $dbname;

        // Call the connect method in the constructor
        $this->connect();
    }

    public function connect(): void
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname";
            $this->connection = new PDO($dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //echo "Connected to the database!";
        } catch (PDOException $error) {
            echo "Connection failed: " . $error->getMessage();
        }
    }
}
