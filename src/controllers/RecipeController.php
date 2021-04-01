<?php

namespace controllers;

require __DIR__ . '/../models/RecipeModel.php';

use models\RecipeModel;

class RecipeController
{
    /**
     * @var RecipeModel Référence vers le modèle des recettes
     */
    private $model;

    public function __construct()
    {
        $this->model = new RecipeModel();
    }

    /**
     * Affiche la liste des recettes
     */
    public function browse(): void
    {
        $recipes = $this->model->getAll();

        require __DIR__ . '/../views/index.php';
    }

    /**
     * Affiche le détail d'une recette
     */
    public function show(int $id): void
    {
        $recipe = $this->model->getById($id);

        require __DIR__ . '/../views/show.php';
    }

    /**
     * Affiche le formulaire d'édition d'une recette
     */
    public function edit(int $id): void
    {
        // On récupère la recette en question
        $recipe = $this->model->getById($id);

        // Initialise le tableau des erreurs
        $errors = [];

        // Si il y a des données postées et que la recette fourni existe
        if (!empty($_POST) && !empty($recipe)) {
            // Mise à jour de la recette avec les données du formulaire
            $recipe['title'] = $_POST['title'];
            $recipe['description'] = $_POST['description'];

            // Récupération des erreurs éventuelles sur la recette
            $errors = $this->model->validate($recipe);

            if (empty($errors)) {
                $this->model->update($recipe);
                header('Location: /');
            }
        }

        require __DIR__ . '/../views/edit.php';
    }

    /**
     * Affiche le formulaire de création d'une recette
     */
    public function add(array $recipe): void
    {
        // Initialise le tableau des erreurs
        $errors = [];

        // Si la recette fourni n'est pas vide
        if (!empty($recipe)) {
            // Récupération des erreurs éventuelles sur la recette
            $errors = $this->model->validate($recipe);
    
            // Si le tableau des erreurs ne contient aucune erreur, 
            // alors on sauvegarde la recette depuis le modèle
            if (empty($errors)) {
                $this->model->add($recipe);
                header('Location: /');
            }
        }

        require __DIR__ . '/../views/form.php';
    }

    /**
     * Affiche le formulaire d'édition d'une recette
     */
    public function save(array $recipe): void
    {
        // On récupère la recette en question
        // TODO à revoir !
        if (!empty($recipe['id']) && empty($this->model->getById($recipe['id']))) {
            header("HTTP/1.0 404 Not Found");
            return;
        }

        // Initialise le tableau des erreurs
        $errors = [];

        // Si la recette fourni existe
        if (!empty($_POST) && !empty($recipe)) {
            // Récupération des erreurs éventuelles sur la recette
            $errors = $this->model->validate($recipe);

            if (empty($errors)) {
                if (!empty($recipe['id'])) {
                    $this->model->update($recipe);
                } else {
                    $this->model->add($recipe);
                }

                header('Location: /');
            }
        }

        require __DIR__ . '/../views/save.php';
    }

    /**
     * Supprime une recette
     */
    public function delete(int $id): void
    {
        $recipe = $this->model->deleteById($id);

        require __DIR__ . '/../views/delete.php';
    }
}
