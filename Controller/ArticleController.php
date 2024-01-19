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
        // Print articles for debugging
       // printR($this->articles);

        $this->articles = $this->getArticles();

        //Change the page name
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

        //Change the page name
        $pageTitle = "Show Articles";

        require 'View/articles/show.php';
    }

    private function getArticleById($articleId)
    {
        if ($articleId === null || !is_numeric($articleId)) {
           // echo "Invalid article ID";
            return null;
        }

        $statement = $this->database->connection->prepare('SELECT * FROM articles WHERE id = :id');
        $statement->bindParam(':id', $articleId);
        $statement->execute();

        $rawArticle = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if the article was found
        if (!$rawArticle) {
            echo "Article not found";
            return null;
        }

        // Pass the article ID as the first argument to the Article constructor
        return new Article($rawArticle['id'], $rawArticle['title'], $rawArticle['description'], $rawArticle['publish_date']);
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

