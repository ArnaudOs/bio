<?php
require_once "Models/ShopModel.php";
require_once "Cart.php";

class ShopController extends Controller {
    protected $modelName = 'ShopModel';

    public function showShop(){
        $arrivees=$this->model->showAll();
        // $this->view('templates/index', ['arrivées'=>$arrivees]);
        $this->view('templates/boutique');
     
    }

    public function showList(){
        
        // if(isset($_POST['commande'])){
        //     $qtSavon    = filter_input(INPUT_POST, 'qtProductSav', FILTER_SANITIZE_SPECIAL_CHARS);
        //     $qtVaisselle          = filter_input(INPUT_POST, 'qtProductVaisselle', FILTER_SANITIZE_SPECIAL_CHARS);
        //     $qtVaisselle          = filter_input(INPUT_POST, 'qtProductPq', FILTER_SANITIZE_SPECIAL_CHARS);
        //     echo 'Salut vous avez commandé'. $qtSavon .'de savon';
        // }
     
        // var_dump($_POST);
        $products=$this->model->showProduct();
        $this->view('templates/boutique',['products'=>$products]);
     
    }


    // public function addProduct(){
    //     if (!isset($_SESSION['panier'])) {
    //         $_SESSION['panier'] = [];
    //         var_dump($_SESSION);
    //     };
    //     $panier = $_SESSION['panier'];
    //     $this->view('templates/test',['panier'=>$panier]);
    // }

public function addToCart(){

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
        var_dump($_SESSION);
    };
    $panier = $_SESSION['panier'];
    $this->view('templates/test',['panier'=>$panier]);

        // get the product id
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
    // $page = isset($_GET['page']) ? $_GET['page'] : 1;
    
    // make quantity a minimum of 1
    $quantity=$quantity<=0 ? 1 : $quantity;
    
    // add new item on array
    $cart_item=array(
        'quantity'=>$quantity
    );
    
    /*
    * check if the 'cart' session array was created
    * if it is NOT, create the 'cart' session array
    */
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    // check if the item is in the array, if it is, do not add
    if(array_key_exists($id, $_SESSION['cart'])){
        // redirect to product list and tell the user it was added to cart
        Session::addFlash('error', "Le produit existe déjà");
        Http::redirect('index.php?controller=Shop&task=showList' . $id);
        var_dump($_SESSION['cart']);
    }
  
    // else, add the item to the array
    else{
        $_SESSION['cart'][$id]=$cart_item;
    
        // redirect to product list and tell the user it was added to cart
        Session::addFlash('success', "Le produit a été ajouté");
        Http::redirect('index.php?controller=Shop&task=showList');
    }
  
}  
  

}








?>