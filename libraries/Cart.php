<?php
// require_once("../../admin/libraries/Session.php");

class Cart
{
    protected static $panier = [];

    public static function load()
    {
       
        if (isset($_SESSION['panier'])) {
            self::$panier = $_SESSION['panier'];
        }
    }
    public static function save()
    {
        $_SESSION['panier'] = self::$panier;
    }
    public  function get()
    {
        self::load();
        return self::$panier;
    }


    public static function add($product, $quantity)
    {
        $id = $product->id;
        echo $id;
        self::load();
//si le produit est déjà présent 
       
        if (array_key_exists($id, self::$panier)) {
   
            self::$panier[$id]['quantity'] = $quantity;
         
   
        }
//sinon

        else {
            // $data = [
            //     'plat' => $plat,
            //     'quantity' => $quantity
            // ];
            self::$panier[$id] = compact('product', 'quantity');
      
        }

        self::save();
        // session_destroy();//aTESTER
    }


}


?>