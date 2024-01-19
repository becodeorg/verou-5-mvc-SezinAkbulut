<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./Stylesheet/style.css">

    <!--Change the page name-->
    <title><?= $pageTitle ?? 'Becode - Boiler plate MVC' ?></title>
</head>
<body>
    <header>
        <nav class="nav">
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="index.php?action=articles-index">Articles</a>
                </li>
            </ul>
        </nav>
    </header>