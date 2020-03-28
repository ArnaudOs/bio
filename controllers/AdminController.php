<?php
require_once "Models/ShopModel.php";

class AdminController extends Controller {
    protected $modelName = 'AdminModel';

    public function showAdm(){
        // $arrivees=$this->model->showAll();
        // $this->view('templates/index', ['arrivées'=>$arrivees]);
        $products=$this->model->showProduct();
        $this->view('templates/admin/admin',['products'=>$products]); 
    }

    public function showForm(){
        //a rajouter une fois session admin crée
        // Request::redirectIfNotAdmin();
        $this->view('templates/admin/formImg');
    }

    public function showProducts(){
        //a rajouter une fois session admin crée
        // Request::redirectIfNotAdmin();
        $products=$this->model->showProduct();
        $this->view('templates/admin/produits_admin',['products'=>$products]);
    }

   

//*************Upload Image */
    public function uploadAllGalerie($path, $insert){
        //a rajouter une fois session admin crée
        // Request::redirectIfNotAdmin();
        if(isset($_POST['submit'])) {
    
            $filename =$_FILES['uploadfile']['name'] ;
            $imagetitle=mb_strtolower(filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS));
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
            $filetmpname = $_FILES['uploadfile']['tmp_name'];
            $folder = "images/$path/";
            move_uploaded_file($filetmpname, $folder.$filename);
            $this->model->$insert($filename, $price, $imagetitle);
        }
       
    }

    public function uploadProd(){
        $path="products";
        $insert="insertProd";
        $this->uploadAllGalerie($path,$insert);
          
            Session::addFlash('success', "L'image a été ajoutée");
           
    }

    public function uploadImageAll(){
        $categories=Request::get('categories', Request::SAFE);
        if($categories == "produits"){
            $this->uploadProd();
            Session::addFlash('success', "L'image a été ajoutée");
            Http::redirect("index.php?controller=Shop&task=showList");
        }
    }
//*************************************** */   

       //*pour éditer les images  
       public function editProduct(){
        $id=Request::get('id', Request::INT);
        if (!$id) {
            Session::addFlash('error', "Erreur");
           Http::redirect('index.php');
        }
        $product =$this->model->findImgProd($id);
        $products=$this->model->showProduct();
        $this->view('templates/admin/editProd', ['product' => $product,'products' => $products]);
    }
    
    public function updateProd(){
        // Request::redirectIfNotSubmitted('index.php');

        $filename =$_FILES['fileupdate']['name'] ;
        $filetmpname = $_FILES['fileupdate']['tmp_name'];
        $folder = "images/products/";
        move_uploaded_file($filetmpname, $folder.$filename);

        // $filename= Request::get('fileupdate', Request::SAFE);
        $imagetitle= Request::get('titleText', Request::SAFE);
        $price= Request::get('price');
        $id = Request::get('id', Request::INT);


        // if (!$filename || !$id || !$price || !$imagetitle ) {
        //     Session::addFlash('error', "Erreur");
        //     Http::redirectBack();
        // }

        $product = $this->model->findImgProd($id);

        if (!$product) {
            Http::redirectBack();
        }

        // $data = compact('name_image', 'titre', 'id');
       


        $this->model->updateImageProd($filename, $id, $price, $imagetitle);

        Session::addFlash('success', "L'image a été modifiée");
        Http::redirect("index.php?controller=Admin&task=showProduct");



    }
    public function deleteProd()
    {
        // Request::redirectIfNotAdmin();
        $id = Request::get('id', Request::INT);
   
        if (!$id) {
            Session::addFlash('error', "");
            Http::redirect('index.php');
        }
        $product =$this->model->findImgProd($id);
        $this->model->delete($id);
        
        $nomImg= $product['img_name'];
        unlink("images/products/$nomImg");
        Session::addFlash('success', "L'image a été supprimée définitivement");
          Http::redirect('index.php?controller=GalerieAmbiance&task=showAmbianceGalerie');
    }

    
  

}








?>