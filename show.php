<?php

require_once 'config.php';

require_once __DIR__ . '/src/models/recipe-model.php';

// Input GET parameter validation (integer >0)
// localhost:8000/show.php?id=1
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

if (false === $id || null === $id) {
    exit("Wrong input parameter");
}

// Fetching a recipe
$recipe = getRecipeById($id);

// Database result check
if (!isset($recipe['title']) || !isset($recipe['description'])) {
    exit("Recipe not found");
}

// Generate the web page
require_once __DIR__ . '/src/views/show.php';