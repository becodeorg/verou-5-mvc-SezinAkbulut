<?php require 'View/includes/header.php'?>

<?php ?>

    <section>
        <h1><?= $this->article->title ?></h1>
        <p><?= $this->article->formatPublishDate() ?></p>
        <p><?= $this->article->description ?></p>

        <!-- links to next and previous -->
        <?php if ($this->prevArticleId !== null): ?>
            <a href="index.php?action=articles-index-show&id=<?= $this->prevArticleId ?>">Previous article</a>
        <?php endif; ?>

        <?php if ($this->nextArticleId !== null): ?>
            <a href="index.php?action=articles-index-show&id=<?= $this->nextArticleId ?>">Next article</a>
        <?php endif; ?>
    </section>

<?php require 'View/includes/footer.php'?>