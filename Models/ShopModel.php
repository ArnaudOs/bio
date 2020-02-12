<?php
require_once "Model.php";
class ShopModel extends Model{

    protected $table = "products";


    public function showProduct(){

        $query = $this->db->prepare("SELECT * FROM `products`");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
                }
}
?>