<?php

require_once 'config.php';

require_once __DIR__ . '/src/models/recipe-model.php';

$errors = [];

if (!empty($_POST)) {
    $title = $_POST['title'];
    $description = $_POST['description'];

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

require __DIR__ . '/src/views/form.php';