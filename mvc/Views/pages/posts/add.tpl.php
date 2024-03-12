<!-- Construction d'un form pour ajouter un post -->

<!-- Affiche les erreurs -->
<?php if (!empty($errorList)) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errorList as $errorContext) : ?>
                <?php foreach ($errorContext as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- bouton de retour -->
<a href="/posts">Retour</a>

<h1>Ajouter un post</h1>

<form method="post">
    <div>
        <label for="title">Titre</label>
        <input type="text" id="title" name="title">
    </div>
    <div>
        <label for="content">Contenu</label>
        <textarea id="content" name="content"></textarea>
    </div>
    <div>
        <label for="author">Auteur</label>
        <input type="text" id="author" name="author">
    </div>
    <div>
        <input type="submit" value="Ajouter">
    </div>
</form>