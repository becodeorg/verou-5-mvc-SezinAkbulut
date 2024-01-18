<?php


declare(strict_types=1);

class ArticleController
{
    private $database;

    // This class needs a database connection to function
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function index()
    {
        // Load all required data
        $articles = $this->getArticles();

        // Load the view
        require 'View/articles/index.php';
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
        $article = $this->getArticleById($articleId);

        if (!$article) {
            // Handle the case where no article is found with the given ID
            // For simplicity, redirect to the articles index
            header('Location: index.php?page=articles-index');
            exit();
        }

        // Load the view for the article detail page
        require 'View/articles/show.php';
    }

    private function getArticles(): array
    {
        // Fetch all articles from the database
        try {
            $query = "SELECT * FROM articles";
            $statement = $this->database->connect()->query($query);
            $rawArticles = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Convert the fetched data into Article objects
            $articles = [];
            foreach ($rawArticles as $rawArticle) {
                $articles[] = new Article($rawArticle['title'], $rawArticle['description'], $rawArticle['publish_date']);
            }

            return $articles;
        } catch (PDOException $err) {
            throw new RuntimeException($err->getMessage(), (int)$err->getCode());
        }
    }

    private function getArticleById(int $articleId): ?Article
    {
        try {
            $query = "SELECT * FROM articles WHERE id = :id";
            $statement = $this->database->connect()->prepare($query);
            $statement->bindParam(':id', $articleId, PDO::PARAM_INT);
            $statement->execute();

            $rawArticle = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$rawArticle) {
                return null;
            }

            return new Article($rawArticle['title'], $rawArticle['description'], $rawArticle['publish_date']);
        } catch (PDOException $err) {
            throw new RuntimeException($err->getMessage(), (int)$err->getCode());
        }
    }
}
