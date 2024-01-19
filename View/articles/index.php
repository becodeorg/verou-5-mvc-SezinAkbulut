
<?php require 'View/includes/header.php'; ?>

<section>
    <h1>Articles</h1>
    <ul>
        <?php foreach ($this->articles as $article) : ?>
            <li><?= $article->title ?> - By <?= $article->author ?> (<?= $article->formatPublishDate() ?>)</li>
            <a href="index.php?action=articles-show&id=<?= $article->id ?>">More info</a>
        <?php endforeach; ?>
    </ul>
</section>

<?php require 'View/includes/footer.php'; ?>

