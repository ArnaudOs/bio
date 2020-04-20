<?php
require_once("../admin/libraries/Http.php");
require_once("../admin/libraries/Session.php");


$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {

    die("pas d'identifiant de produit à supprimer");
}

unset($_SESSION['panier'][$id]);


// var_dump($_SESSION['panier']);

Http::redirectBack();
?>