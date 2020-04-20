<?php
require_once "libraries/Cart.php";

class PanierController extends Controller{

protected $modelName = 'PanierModel';

// public function indexPanier()
// {
//     $plats = $this->model->findPlats();
//     $this->view('plat-panier', ['plats' => $plats]);
// }
public function showPanier(){

    $this->view('templates/panier');
    

}
public function addOrder(){

    $this->view('add-order');

}
public function showOrder(){

    $this->view('save-order');

}
public function showCart(){
   
    $products=$this->model->findProducts();
    // $quantity=$this->addToCart();
    $this->view('templates/cart',['products'=>$products,'quantity'=>$quantity]);


}

public function addPanier(){
   
    $productId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'qtProduct', FILTER_VALIDATE_INT);
    if (!$productId || !$quantity || !$price) {
        die("aucun identifiant n'a été trouvé.");
    }
    $produit = $this->model->addingPanier($productId);
    var_dump($_SESSION['panier']);
    var_dump($_POST);
     Cart::add($produit, $quantity, $price);
     $this->view('templates/panier');
}

// protected static function load()
// {
//     if (isset($_SESSION['panier'])) {
//         self::$panier = $_SESSION['panier'];
//     }
// }
// protected static function save()
// {
//     $_SESSION['panier'] = self::$panier;
// }
// public static function get()
// {
//     self::load();
//     return self::$panier;
// }


// public function add($product, $quantity)
// {
//     $id = $product->id;


//     self::load();
// //si le produit est déjà présent 
//     if (array_key_exists($id, self::$panier)) {
//         self::$panier[$id]['qty'] += $quantity;
//     }
// //sinon

//     else {
//         // $data = [
//         //     'plat' => $plat,
//         //     'quantity' => $quantity
//         // ];
//         self::$panier[$id] = compact('plat', 'qty');
//     }

//     self::save();
// }





public function addToCart(){
    session_start();
 
	if(isset($_GET['id']) & !empty($_GET['id'])){
		if(isset($_SESSION['cart']) & !empty($_SESSION['cart'])){
        $quantity = $_SESSION['quantity'];
		$items = $_SESSION['cart'];
		$cartitems = explode(",", $items);
            if(in_array($_GET['id'], $cartitems)) {
                header('location: index.php?controller=Shop&task=showList');
                // Http::redirect("index.php?controller=Shop&task=showList&=incart");
            } else {
                $items .= "," . $_GET['id'];
                $_SESSION['cart'] = $items;
                header('location: index.php?status=success');
            }
        
		}else {
        $items = $_GET['id'];
        $quantity =$_GET['qty'];
        $_SESSION['cart'] = $items;
        $_SESSION['quantity'] = $quantity;
		header('location: index.php?status=success');
		}
		
	}else{
		header('location: index.php?status=failed');
	}
}
public function deleteCart(){
    
    $items = $_SESSION['cart'];
    $cartitems = explode(",", $items);
    if(isset($_GET['remove']) & !empty($_GET['remove'])){
        $delitem = $_GET['remove'];
        unset($cartitems[$delitem]);
        $itemids = implode(",", $cartitems);
        $_SESSION['cart'] = $itemids;
    }
}

}

?>