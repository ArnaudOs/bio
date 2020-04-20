<?php
require_once("../admin/libraries/Session.php");
require_once("libraries/Database.php");
require_once("libraries/Cart.php");


var_dump($_POST);

//1connexion à la base de données

$pdo = Database::getInstance();

//2 on va chercher le plat(on a donc besoin de l'id)
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
if (!$id || !$quantity) {
    die("aucun identifiant n'a été trouvé.");
}
$query = $pdo->prepare('SELECT*FROM plats WHERE id=:id');
$query->execute([':id' => $id]);//on peut ne pas mettre les deux points dans le token en execute 'id'
$product = $query->fetch();

// var_dump($plat);


//3on construit la structure du plat au sein de panier
Cart::add($product, $quantity);


header('Location: panier.php');
var_dump($_SESSION);
?>