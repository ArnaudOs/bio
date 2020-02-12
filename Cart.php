<?php
// require_once("../../admin/libraries/Session.php");

class Cart
{


    private $productType=array();

    protected static $panier = [];

    protected static function load()
    {
        if (isset($_SESSION['panier'])) {
            self::$panier = $_SESSION['panier'];
        }
    }
    protected static function save()
    {
        $_SESSION['panier'] = self::$panier;
    }
    public static function get()
    {
        self::load();
        return self::$panier;
    }


    public function add($product, $quantity)
    {
        $id = $product->id;


        self::load();
//si le produit est déjà présent 
        if (array_key_exists($id, self::$panier)) {
            self::$panier[$id]['quantity'] += $quantity;
        }
//sinon

        else {
            // $data = [
            //     'plat' => $plat,
            //     'quantity' => $quantity
            // ];
            self::$panier[$id] = compact('plat', 'quantity');
        }

        self::save();
    }


}


?>