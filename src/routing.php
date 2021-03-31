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

} else {
    header('HTTP/1.1 404 Not Found');

}