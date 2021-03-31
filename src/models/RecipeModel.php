<?php

namespace models;

use \PDO;

class RecipeModel
{
    /**
     * @var PDO Référence vers la connexion à la base de données
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USER, PASSWORD);
    }

    /**
     * Renvoi la liste de toutes les recettes
     */
    public function getAll(): array
    {
        $statement = $this->connection->query('SELECT id, title FROM recipe');
        $recipes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $recipes;
    }

    /**
     * Renvoi la recette correspondant à l'identifiant fourni
     */
    public function getById(int $id): array
    {
        $statement = $this->connection->prepare('SELECT id, title, description FROM recipe WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Sauvegarde la recette fourni en BDD
     */
    public function add(array $recipe): bool
    {
        $statement = $this->connection->prepare('INSERT INTO recipe (title, description) VALUES(:title, :description)');
        $statement->bindValue(':title', $recipe['title']);
        $statement->bindValue(':description', $recipe['description']);
        
        return $statement->execute();
    }
}
