<?php
ob_start();
// define('ROOT_PATH', DIR);

$controllerName = filter_input(INPUT_GET, 'controller', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$controllerName) {
    $controllerName = "Accueil"; 
}

$controllerName .= "Controller";

require_once "configuration.php";
require_once "controllers/$controllerName.php";

$controller = new $controllerName();



$task = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$task) {
    $task = "showIndex"; 
}

// if(empty($_GET)){
//     $template="index.php?controller=Accueil&task=index";
//     require 'templates/index.phtml';
//     require_once 'templates/partials/footer.phtml';
//     exit;
// }

$controller->$task();