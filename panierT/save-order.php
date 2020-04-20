<?php
require_once("../admin/libraries/Session.php");
require_once("libraries/Database.php");

$panier = $_SESSION['panier'];

// var_dump($_POST);
//1 extraction des données du formulaire
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
if (!$phone || !$address) {
    die("die die");
}

//2.connexion à la base de données




$pdo = Database::getInstance();


//3. on insère la nouvelle commande
$query = $pdo->prepare('
INSERT INTO orders SET
phone = :phone,
address=:address,
orderdate=NOW()
');
$query->execute(compact('phone', 'address'));

$order_id = $pdo->lastInsertID();


$query = $pdo->prepare('
INSERT into orders_plat SET

order_id=:order_id,
plat_id=:plats_id,
quantity=:quantity
');
//5 ppour chaque produit du panier
foreach ($panier as $id => $element) {
    $plats_id = $id;
    $quantity = $element['quantity'];

    $query->execute(compact('order_id', 'plats_id', 'quantity'));
}
//6 calculer le total du panier
$total = 0;
foreach ($panier as $element) {
    $totalElement = $element['quantity'] * $element['plat']->prix;
    $total = $total + $totalElement;

}
//même chose qu'au dessus c'est une réduction de tableau
$montantTotal = array_reduce($panier, function ($acc, $element) {
    $totalElement = $element['quantity'] * $element['plat']->prix;
    return $acc + $totalElement;
}, 0);


require_once("../panier/header.phtml");
require_once("../admin/template/save-order.phtml");
?>
