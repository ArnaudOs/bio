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
        
        $products=$this->model->showProduct();
        $this->view('templates/boutiqueProd',['products'=>$products]);
     
    }
 

}








?>