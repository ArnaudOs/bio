<?php
require_once "Models/PayModel.php";


class PayController extends Controller {
    protected $modelName = 'PayModel';

    public function showStripe(){

    
        // $user = $_SESSION['user'];
        // $mail = $_SESSION['mail'];
            // $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
            // $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
            // $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
            // var_dump($_POST);
            // $user=$_POST['nom'].$_POST['prenom'];
            // $mail = $_POST['mail'];
            // $_SESSION['user']=$user;
            // $_SESSION['mail'] = $mail   ;
            // $_SESSION['user']= $nom .   $prenom ;
            // $_SESSION['mail'] =  $mail ;
            // $user = $_SESSION['user'];
            // $mail = $_SESSION['mail'];
            // $panier = $_SESSION['panier'];
            $this->view('templates/formPay');
        //    var_dump($_SESSION);
            // if( $successMessage!=null){
            //   HTTP::redirect("index.php?controller=PanierTest&task=showOrder");
            // }
           
    }


}








?>