<?php


declare(strict_types=1);

class ArticleController
{
    private $database;
    private $articles;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->articles = $this->getArticles();
    }

    public function index()
    {
        printR($this->articles);

        $this->articles = $this->getArticles();

        // Load the view
        require 'View/articles/index.php';
    }


    // Note: this function can also be used in a repository - the choice is yours
    private function getArticles()
    {
        try {
            $connection = $this->database->connection;
            $tableName = 'articles';
            $query = "SELECT * FROM $tableName";
            $statement = $connection->query($query);
            $rawArticles = $statement->fetchAll();

            foreach ($rawArticles as $rawArticle) {
                $articles[] = new Article($rawArticle['id'], $rawArticle['title'], $rawArticle['description'], $rawArticle['publish_date']);
            }

        } catch (PDOException $e) {
            echo "Query Failed: " . $e->getMessage();
        }
        return $articles;
    }

    public function showArticle()
    {
        $article = $this->show();
        require 'View/articles/show.php';
    }

    public function show()
    {
        try {
            $connection = $this->database->connection;
            $tableName = 'articles';
            $id = $_GET['id'];
            $query = "SELECT * FROM $tableName WHERE id = $id";
            $statement = $connection->query($query);
            $rawArticle = $statement->fetchAll();
            $article = new Article($rawArticle[0]['id'], $rawArticle[0]['title'], $rawArticle[0]['description'], $rawArticle[0]['publish_date']);
            return $article;

        }catch (PDOException $e) {
            echo "Query Failed: " . $e->getMessage();
        }
    }
}