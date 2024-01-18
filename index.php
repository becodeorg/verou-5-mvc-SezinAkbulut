<?php

// Require the correct variable type to be used (no auto-converting)
declare(strict_types=1);

// Show errors so we get helpful information
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



// Load your classes
require_once 'Core/database.php';

// Include all your model files here
require 'Model/Article.php';

// Include all your controllers here
require 'Controller/HomepageController.php';
require 'Controller/ArticleController.php';


$database = new Database($config['host'], $config['user'], $config['password'], $config['dbname']);
$database->connect();

$action = $_GET['action'] ?? null;

switch ($action) {
    case 'articles-index':
        (new ArticleController($database))->index();
        break;
    case 'articles-show':
        // TODO: detail page
    case 'home':
    default:
        (new HomepageController())->index();
        break;
}