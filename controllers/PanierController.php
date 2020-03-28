<?php
require_once "libraries/Cart.php";

class PanierController extends Controller{

protected $modelName = 'PanierModel';

// public function indexPanier()
// {
//     $plats = $this->model->findPlats();
//     $this->view('plat-panier', ['plats' => $plats]);
// }
public function showPanier(){

    $this->view('templates/panier');
    

}
public function addOrder(){

    $this->view('add-order');

}
public function showOrder(){

    $this->view('save-order');

}

public function addPanier(){
   
    $productId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'qtProduct', FILTER_VALIDATE_INT);
    if (!$productId || !$quantity || !$price) {
        die("aucun identifiant n'a été trouvé.");
    }
    $produit = $this->model->addingPanier($productId);
    var_dump($_SESSION['panier']);
    var_dump($_POST);
     Cart::add($produit, $quantity, $price);
     $this->view('templates/panier');
}

}

?>