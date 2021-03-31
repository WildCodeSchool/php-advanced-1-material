<?php

/**
 * Renvoie une connexion vers la BDD
 */
function createConnection(): PDO
{
    return new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USER, PASSWORD);
}

/**
 * Renvoie la liste de toutes les recettes
 */
function getAllRecipes(): array
{
    $connection = createConnection();

    $statement = $connection->query('SELECT id, title FROM recipe');
    $recipes = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $recipes;
}

/**
 * Renvoi la recette pour l'identifiant donné
 */
function getRecipeById(int $id): array
{
    $connection = createConnection();

    $query = 'SELECT title, description FROM recipe WHERE id=:id';
    $statement = $connection->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $recipe = $statement->fetch(PDO::FETCH_ASSOC);

    return empty($recipe) ? [] : $recipe;
}

/**
 * Sauvegarde la recette donnée
 * 
 * @param Array La recette à sauvegarder
 */
function saveRecipe(array $recipe): void
{
    $connection = createConnection();

    $query = "INSERT INTO recipe (title, description) VALUES (:title, :description)";
    
    $statement = $connection->prepare($query);
    $statement->bindValue(':title', $recipe['title']);
    $statement->bindValue(':description', $recipe['description']);

    $statement->execute();
}
