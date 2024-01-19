<?php

// Require the correct variable type to be used (no auto-converting)
declare(strict_types=1);

// Show errors so we get helpful information
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


//Database secret info's
require 'config.php';

// Load class
require_once 'Core/database.php';

// Include all your model files here
require 'Model/Article.php';

// Include all your controllers here
require 'Controller/HomepageController.php';
require 'Controller/ArticleController.php';

//print Function for easy printing

function printR($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}


$database = new Database($config['host'], $config['user'], $config['password'], $config['dbname']);
$database->connect();

$action = $_GET['action'] ?? null;

switch ($action) {
    case 'articles-index':
        (new ArticleController($database))->index();
        break;
    case 'articles-show':
        $articleId = $_GET['id'] ?? null;
        (new ArticleController($database))->show($articleId);
        break;
    case 'home':
    default:
        (new HomepageController())->index();
        break;
}