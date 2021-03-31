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
     * Affiche le formulaire de création d'une recette
     */
    public function add(array $recipe): void
    {
        // Initialise le tableau des erreurs
        $errors = [];

        // Si la recette fourni n'est pas vide
        if (!empty($recipe)) {
            // Vérification du titre
            if (empty($recipe['title']) || strlen($recipe['title']) < 5) {
                $errors[] = 'Le titre est incorrect';
            }
    
            // Vérification de la description
            if (empty($recipe['description']) || strlen($recipe['description']) < 10) {
                $errors[] = 'La description est incorrecte';
            }
    
            // Si le tableau des erreurs ne contient aucune erreur, 
            // alors on sauvegarde la recette depuis le modèle
            if (empty($errors)) {
                $this->model->add($recipe);
                header('Location: /');
            }
        }

        require __DIR__ . '/../views/form.php';
    }
}
