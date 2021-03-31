<?php

require __DIR__ . '/../models/recipe-model.php';

/**
 * Affiche la liste des recettes
 */
function browseRecipes(): void
{
    $recipes = getAllRecipes();

    require __DIR__ . '/../views/index.php';
}

/**
 * Affiche le détail d'une recette
 */
function showRecipe(int $id)
{
    $id = filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

    if (false === $id || null === $id) {
        header('HTTP/1.1 400 Bad request');
        return;
    }

    // Fetching a recipe
    $recipe = getRecipeById($id);

    // Database result check
    if (!isset($recipe['title']) || !isset($recipe['description'])) {
        header('HTTP/1.1 404 Not found');
        return;
    }

    // Generate the web page
    require_once __DIR__ . '/../views/show.php';
}

/**
 * Affiche le formulaire de création d'une recette
 */
function addRecipe(array $recipe)
{
    $errors = [];

    if (!empty($recipe)) {
        $title = $recipe['title'];
        $description = $recipe['description'];

        if (strlen($title ) > 100) {
            $errors[] = 'titre trop long';
        }

        if (strlen($title ) < 5) {
            $errors[] = 'titre trop court';
        }

        if (strlen($description) > 1000) {
            $errors[] = 'description trop longue';
        }

        if (strlen($description) < 10) {
            $errors[] = 'description trop courte';
        }

        if (empty($errors)) {
            saveRecipe([
                'title' => $title,
                'description' => $description,
            ]);

            // On redirige vers la page /
            header('Location: /');
        }
    }

    require __DIR__ . '/../views/form.php';
}
