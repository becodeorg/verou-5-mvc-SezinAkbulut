<?php require 'View/includes/header.php'?>

<?php // Use any data loaded in the controller here ?>

    <section>
        <h1><?= $article->title ?></h1>
        <p><?= $article->formatPublishDate() ?></p>
        <p><?= $article->description ?></p>

        <!-- links to next and previous -->
        <?php if ($prevArticleId !== null):  ?>
            <a href="index.php?page=articles-show&id=<?= $prevArticleId ?>">Previous article</a>
        <?php endif; ?>

        <?php if ($nextArticleId !== null):  ?>
            <a href="index.php?page=articles-show&id=<?= $nextArticleId ?>">Next article</a>
        <?php endif; ?>
    </section>

<?php require 'View/includes/footer.php'?>