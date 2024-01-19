<?php


declare(strict_types=1);
/*
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
        // Get the article ID from the query string
        $articleId = $_GET['article_id'] ?? null;

        if (!$articleId) {
            // Handle the case where no article ID is provided
            // For simplicity, redirect to the articles index
            header('Location: index.php?page=articles-index');
            exit();
        }

        // Load the specific article
        $this->article = $this->getArticleById($articleId);

        if (!$this->article) {
            // Handle the case where no article is found with the given ID
            // For simplicity, redirect to the articles index
            header('Location: index.php?page=articles-index');
            exit();
        }

        // Load the view for the article detail page
        require 'View/articles/show.php';
    }
}
*/

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
        // Print articles for debugging
        printR($this->articles);

        $this->articles = $this->getArticles();

        $pageTitle = "Articles";
        // Load the view
        require 'View/articles/index.php';
    }

    // Note: this function can also be used in a repository - the choice is yours
    private function getArticles()
    {
        $articles = [];  // Initialize the variable
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

    public function show($articleId)
    {
        $article = $this->getArticleById($articleId);

        $prevArticleId = $this->getPrevArticleId($articleId);
        $nextArticleId = $this->getNextArticleId($articleId);

        $pageTitle = "Show Articles";

        require 'View/articles/show.php';
    }

    private function getArticleById($articleId)
    {
        if ($articleId === null || !is_numeric($articleId)) {

            echo "Invalid article ID";
            return null;
        }
        $statement = $this->database->connection->prepare('SELECT * FROM articles WHERE id = :id');
        $statement->bindParam(':id', $articleId);
        $statement->execute();

        $rawArticle = $statement->fetch(PDO::FETCH_ASSOC);

        return new Article($rawArticle['title'], $rawArticle['description'], $rawArticle['publish_date']);
    }

    private function getPrevArticleId($currentArticleId)
    {
        $statement = $this->database->connection->prepare('SELECT id FROM articles WHERE id < :currentId ORDER BY id DESC LIMIT 1');
        $statement->bindParam(':currentId', $currentArticleId);
        $statement->execute();

        $prevArticleId = $statement->fetch(PDO::FETCH_COLUMN);

        return $prevArticleId;
    }

    private function getNextArticleId($currentArticleId)
    {
        $statement = $this->database->connection->prepare('SELECT id FROM articles WHERE id > :currentId ORDER BY id ASC LIMIT 1');
        $statement->bindParam(':currentId', $currentArticleId);
        $statement->execute();

        $nextArticleId = $statement->fetch(PDO::FETCH_COLUMN);

        return $nextArticleId;
    }

}

