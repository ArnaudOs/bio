<?php
require_once "controller.php";
require_once "panierT/libraries/Cart.php";

class PanierTestController extends Controller{


    protected $modelName = 'PanierTestModel';

    public function indexPanier()
    {

    
        $products = $this->model->findProducts();

        $this->view('templates/produit-panier', ['products' => $products]);
        
    }
public function addOrder(){
    
    $this->view('templates/add-order');

}
public function showOrder(){

    $this->view('templates/save-order');
   

}
public function showCart(){

    $this->view('templates/panier');
   

}

public function addPanier(){
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    if (!$id || !$quantity) {
        die("aucun identifiant n'a été trouvé.");
    }
  $product =$this->model->addingPanier($id);

  Cart::add($product, $quantity);
 
}
public function addingCart(){
    var_dump($_POST);

    //1connexion à la base de données
    
    $pdo = PanierTestModel::getInstance();
    
    //2 on va chercher le plat(on a donc besoin de l'id)
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    if (!$id || !$quantity) {
        die("aucun identifiant n'a été trouvé.");
    }
    $query = $pdo->prepare('SELECT*FROM products WHERE id=:id');
    $query->execute([':id' => $id]);//on peut ne pas mettre les deux points dans le token en execute 'id'
    $product = $query->fetch();
    
    // var_dump($plat);
    
    
    //3on construit la structure du plat au sein de panier
    Cart::add($product, $quantity);
    
    
    Http::redirect("index.php?controller=PanierTest&task=showCart");
    var_dump($_SESSION);
    
}
public function deleteItem(){
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$id) {

        die("pas d'identifiant de produit à supprimer");
    }

    unset($_SESSION['panier'][$id]);


    // var_dump($_SESSION['panier']);

    Http::redirectBack();
}

public function updateItem() {

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
Http::redirect("index.php?controller=PanierTest&task=showCart");



var_dump($_POST);
}
}