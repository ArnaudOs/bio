<?php
require_once "Models/AccueilModel.php";

class AccueilController extends Controller {
    protected $modelName = 'AccueilModel';

    public function showIndex(){
        // $arrivees=$this->model->showAll();
        // $this->view('templates/index', ['arrivées'=>$arrivees]);
        $this->view('templates/index');
     
    }
  

}








?>