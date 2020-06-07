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
        $this->view('templates/cartok', ['products' => $products]);
        
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

public function showOrder(){
    $panier = $_SESSION['panier'];
    $this->view('templates/order',['panier' => $panier]);

}
public function showCart(){

    $products = $this->model->findProducts();
    $this->view('templates/cartok',['products' => $products]);
   

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
Http::redirect("index.php?controller=PanierTest&task=showCart");
}
public function showCommande(){

    $this->view('templates/commande');
    // var_dump($_SESSION['panier']);
        // var_dump($test);
        $panier = $_SESSION['panier'];
//   var_dump($panier);
        // var_dump( $panier [1]['product']->price);
}


public function insertOrders(){

    $panier = $_SESSION['panier'];
  
    // $arrayProduct= array(
     
    //     '1'=>'art_un',
    //     '2'=>'art_deux',
    //     '3'=>'art_trois',
    //     '4'=>'art_quatre',
    //     '5'=>'art_cinq',
    //     '6'=>'art_six',
    //     '7'=>'art_sept',
    //     '8'=>'art_huit',
    //     '9'=>'art_neuf',
    //     '10'=>'art_dix',
    //     '11'=>'art_onze',
    //     '12'=>'art_douze',
    //     '13'=>'art_treize'

    // );
    // var_dump($arrayProduct);

    // foreach ($panier as $id => $element) {
    //     $plats_id = $id;
    //     $quantity = $element['quantity'];

    //     $query->execute(compact('order_id', 'plats_id', 'quantity'));
    // }
    //6 calculer le total du panier
    // $total = 0;
    // foreach ($panier as $element) {
    //     $totalElement = $element['quantity'] * $element['plat']->prix;
    //     $total = $total + $totalElement;

    // }
    // //même chose qu'au dessus c'est une réduction de tableau
    // $montantTotal = array_reduce($panier, function ($acc, $element) {
    //     $totalElement = $element['quantity'] * $element['plat']->prix;
    //     return $acc + $totalElement;
    // }, 0);


    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
    $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $livraison = filter_input(INPUT_POST, 'livraison', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$phone || !$address || !$mail || !$nom ||!$prenom ||!$livraison) {
        die("die die");
    }
   
    $newUser= $prenom . " " . $nom;
    $email= $mail;
    $sendmail=$this->model->mailOrders($email,$newUser);
    $orders =$this->model->insertOrder($panier, $nom, $prenom,$mail,$phone,$address,$livraison);
   
    // Http::redirect("index.php?controller=PanierTest&task=showOrder");

}
}