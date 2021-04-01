<?php

require __DIR__.'/controllers/RecipeController.php';

use controllers\RecipeController;

$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ('/' === $urlPath) {
    (new RecipeController())->browse();

} elseif ('/show' === $urlPath && isset($_GET['id'])) {
    (new RecipeController())->show($_GET['id']);

} elseif ('/add' === $urlPath) {
    (new RecipeController())->add($_POST);

} elseif ('/edit' === $urlPath) {
    (new RecipeController())->edit($_GET['id']);

} elseif ('/delete' === $urlPath) {
    (new RecipeController())->delete($_GET['id']);

} elseif ('/save' === $urlPath) {
    $recipe = ['id' => isset($_GET['id']) ? $_GET['id'] : null];

    if (!empty($_POST)) {
        $recipe = $_POST;
    }

    (new RecipeController())->save($recipe);

} else {
    header('HTTP/1.1 404 Not Found');

}