<?php require 'View/includes/header.php'?>

<?php
;?>

    <section>
        <?php if ($article !== null): ?>
            <img src="<?= $article->photo ?>" alt="Article Image">
            <h1><?= $article->title ?></h1>
            <p><?= $article->formatPublishDate() ?></p>
            <p><?= $article->description ?></p>
            <p><?= $article->author ?></p>

            <!-- links to next and previous -->
            <?php if ($prevArticleId !== null): ?>
                <a href="index.php?action=articles-show&id=<?= $prevArticleId ?>">Previous article</a>
            <?php endif; ?>

            <?php if ($nextArticleId !== null): ?>
                <a href="index.php?action=articles-show&id=<?= $nextArticleId ?>">Next article</a>
            <?php endif; ?>
        <?php else: ?>
            <p>Article not found</p>
        <?php endif; ?>
    </section>

<?php require 'View/includes/footer.php'?>