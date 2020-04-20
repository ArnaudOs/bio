<?php
session_start();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);


if (!array_key_exists($id, $_SESSION['panier'])) {
    die("Pas de produits $id dans panier");
};

if ($quantity < 1) {
    die("non !");
}
$_SESSION['panier'][$id]['quantity'] = $quantity;
header('Location: panier.php');



var_dump($_POST);


?>