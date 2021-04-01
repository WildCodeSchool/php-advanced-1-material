<?php

namespace models;

use \PDO;

class RecipeModel
{
    /**
     * Indique une erreur sur le champs titre
     */
    public const ERROR_TITLE = 'Le titre est incorrect';

    /**
     * Indique une erreur sur le champs description
     */
    public const ERROR_DESCRIPTION = 'La description est incorrecte';

    /**
     * @var PDO Référence vers la connexion à la base de données
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE . ";charset=utf8", USER, PASSWORD);
    }

    /**
     * Valide la recette données.
     * 
     * Renvoi un tableau contenant les erreurs ou vide si pas d'erreur
     */
    public function validate(array $recipe): array
    {
        // Initialise le tableau des erreurs
        $errors = [];

        // Vérification du titre
        if (empty($recipe['title']) || strlen($recipe['title']) < 5) {
            $errors[] = self::ERROR_TITLE;
        }

        // Vérification de la description
        if (empty($recipe['description']) || strlen($recipe['description']) < 10) {
            $errors[] = self::ERROR_DESCRIPTION;
        }

        return $errors;
    }

    /**
     * Renvoi la liste de toutes les recettes
     */
    public function getAll(): array
    {
        $statement = $this->connection->query('SELECT id, title, description FROM recipe');
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

    /**
     * Met à jour la recette fourni
     */
    public function update(array $recipe): bool
    {
        $statement = $this->connection->prepare('UPDATE recipe SET title = :title, description = :description WHERE id = :id');
        $statement->bindValue(':id', $recipe['id']);
        $statement->bindValue(':title', $recipe['title']);
        $statement->bindValue(':description', $recipe['description']);
        
        return $statement->execute();
    }

    /**
     * Supprime la recette correspondant à l'identifiant fourni
     */
    public function deleteById(int $id): bool
    {
        $statement = $this->connection->prepare('DELETE FROM recipe WHERE id = :id');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}
