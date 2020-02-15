<?php
require_once "Models/ShopModel.php";
require_once "Cart.php";

class AdminController extends Controller {
    protected $modelName = 'AdminModel';

    public function showAdm(){
        // $arrivees=$this->model->showAll();
        // $this->view('templates/index', ['arrivées'=>$arrivees]);
        $products=$this->model->showProduct();
        $this->view('templates/admin',['products'=>$products]);
     
    }

    // public function showList(){
        
    //     // if(isset($_POST['commande'])){
    //     //     $qtSavon    = filter_input(INPUT_POST, 'qtProductSav', FILTER_SANITIZE_SPECIAL_CHARS);
    //     //     $qtVaisselle          = filter_input(INPUT_POST, 'qtProductVaisselle', FILTER_SANITIZE_SPECIAL_CHARS);
    //     //     $qtVaisselle          = filter_input(INPUT_POST, 'qtProductPq', FILTER_SANITIZE_SPECIAL_CHARS);
    //     //     echo 'Salut vous avez commandé'. $qtSavon .'de savon';
    //     // }
     
    //     // var_dump($_POST);
    //     $products=$this->model->showProduct();
    //     $this->view('templates/boutique',['products'=>$products]);
     
    // }

    // public function addProduct(){
    //     if (!isset($_SESSION['panier'])) {
    //         $_SESSION['panier'] = [];
    //         var_dump($_SESSION);
    //     };
    //     $panier = $_SESSION['panier'];
    //     $this->view('templates/test');
    // }

    
  

}








?>