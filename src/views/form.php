<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>New recipe</title>
    </head>
    <body>
        <?php foreach ($errors as $error) : ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endforeach; ?>

        <form method="post">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" />
            </div>

            <div>
                <label for="description">Description</label>
                <input type="text" id="description" name="description" />
            </div>

            <input type="submit" value="Envoyer" />
        </form>
    </body>
</html>
