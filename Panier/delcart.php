<?php 
session_start();
$items = $_SESSION['cart'];
// var_dump($cartitems);
$cartitems = explode(",", $items);
// var_dump($_SESSION);
// var_dump($cartitems);


if(isset($_GET['remove']) & !empty($_GET['remove'])) {
    $delitem = $_GET['remove'];
    echo $delitem ;
    unset($cartitems[$delitem]);
    $itemids = implode(",", $cartitems);
    $_SESSION['cart'] = $itemids; 
}

elseif(isset($_GET['remove']) & count($cartitems)==1) {
    $delitem = $_GET['remove'];
    unset($cartitems[$delitem]);
    // unset($_SESSION['cart']);
    session_destroy();
    // session_start();
    $_SESSION['cart']='';
    echo "il n'y a plus d'item dans le panier";
    header('location:index.php');   
}
// var_dump($_SESSION['cart']);
header('location:cart.php');