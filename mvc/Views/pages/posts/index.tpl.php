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