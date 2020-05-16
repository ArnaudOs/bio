<?php
require_once "controller.php";
require_once "libraries/Cart.php";

class PanierTestController extends Controller{


    protected $modelName = 'PanierTestModel';

    public function indexPanier()
    {
        // var_dump($_SESSION);
        // var_dump($_POST);
        // if($_SESSION['panier']==null){
        //     session_start();
        // }
        $products = $this->model->findProducts();

        // $this->view('templates/produit-panier', ['products' => $products]);
        $this->view('panier/test', ['products' => $products]);

        $pdo = PanierTestModel::getInstance();
    
        //2 on va chercher le plat(on a donc besoin de l'id)
        $id = filter_input(INPUT_POST, 'id');
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
        if (!$id || !$quantity ) {
            die("");
        }
        // else {
        //     echo "vous avez " .count($_SESSION['panier']) . " articles dans le panier";
        // }
        $query = $pdo->prepare('SELECT*FROM products WHERE id=:id');
        $query->execute([':id' => $id]);//on peut ne pas mettre les deux points dans le token en execute 'id'
        $product = $query->fetch();
        

        //3on construit la structure du plat au sein de panier
        Cart::add($product, $quantity);
        Http::redirect("index.php?controller=PanierTest&task=indexPanier");
        
    }
public function addOrder(){
    
    $this->view('templates/add-order');

}
public function showOrder(){

    $this->view('templates/save-order');
   

}
public function showCart(){

    $products = $this->model->findProducts();
    $this->view('panier/test',['products' => $products]);
   

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

public function addArticle($id,$price,$quantity,$title){
    $id = filter_input(INPUT_POST, 'id');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_GET, 'quantity', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title');
    $arr=array();

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    };
    $panier = $_SESSION['panier'];

    array_push($panier, $id, $price, $quantity, $title);
    // Si le panier existe
    if (isset($panier))
    {
       //Si le produit existe déjà on ajoute seulement la quantité
       $positionProduit = array_search( $arr, $panier['title']);
 
       if ($positionProduit !== false)
       {
          $_SESSION['panier']['qty'][$positionProduit] += $quantity ;
       }
       else
       {
          //Sinon on ajoute le produit
          array_push( $_SESSION['panier']['title'],$title);
          array_push( $_SESSION['panier']['qty'],$quantity);
          array_push( $_SESSION['panier']['price'],$price);
       }
    }
}


// public function addingCart(){


//     //1connexion à la base de données
    
//     $pdo = PanierTestModel::getInstance();
    
//     //2 on va chercher le plat(on a donc besoin de l'id)
//     $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
//     $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
//     if (!$id || !$quantity) {
//         die("aucun identifiant n'a été trouvé.");
//     }
//     $query = $pdo->prepare('SELECT*FROM products WHERE id=:id');
//     $query->execute([':id' => $id]);//on peut ne pas mettre les deux points dans le token en execute 'id'
//     $product = $query->fetch();
    
//     // var_dump($plat);
    
    
//     //3on construit la structure du plat au sein de panier
//     Cart::add($product, $quantity);
    
    
//     Http::redirect("index.php?controller=PanierTest&task=indexPanier");
    
    
// }
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

if($_SESSION==null){
    session_start();
}
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);


if (!array_key_exists($id, $_SESSION['panier'])) {
    die("Pas de produits $id dans panier");
};

if ($quantity < 1) {
    die("non !");
}
$_SESSION['panier'][$id]['quantity'] = $quantity;
// Http::redirect("index.php?controller=PanierTest&task=showCart");


}
}