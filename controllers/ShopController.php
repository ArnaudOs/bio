<?php
require_once "Models/ShopModel.php";

class ShopController extends Controller {
    protected $modelName = 'ShopModel';

    public function showShop(){
        $arrivees=$this->model->showAll();
        // $this->view('templates/index', ['arrivées'=>$arrivees]);
        $this->view('templates/boutique');
     
    }
  

}








?>