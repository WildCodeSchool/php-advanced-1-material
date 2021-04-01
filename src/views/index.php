<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>List of Recipes</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <a class="btn btn-primary" href="/save">
                Nouvelle recette
            </a>
            
            <h1>List of Recipes</h1>

            <div class="row g-4">
                <?php foreach ($recipes as $recipe) : ?>
                    <div class="col">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $recipe['title'] ?>
                                </h5>
                                
                                <p class="card-text">
                                    <?= $recipe['description'] ?>
                                </p>
                                
                                <a class="ms-5 my-2 btn btn-danger" href="/delete?id=<?= $recipe['id'] ?>">
                                    Supprimer
                                </a>

                                <a class="ms-1 my-2 btn btn-primary" href="/save?id=<?= $recipe['id'] ?>">
                                    Editer
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </body>
</html>
