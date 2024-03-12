<!-- Affiche les messages flash -->
<?php if (!empty($flashMessages)) : ?>
    <div>
        <ul>
            <?php foreach ($flashMessages as $flashMessage) : ?>
                <li><?= $flashMessage ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Bouton pour ajouter un post -->
<a href="/posts/add">Ajouter un post</a>

<?php if (isset($posts)):
    foreach ($posts as $post): ?>
        <article>
            <h2><?= $post->getTitle() ?></h2>
            <p><?= $post->getContent() ?></p>
            <p><?= $post->getAuthor() ?></p>
            <p><?= $post->getDate() ?></p>
        </article>
    <?php endforeach;
endif; ?>