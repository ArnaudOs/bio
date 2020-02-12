<?php
require_once "Model.php";
class AccueilModel extends Model{

    protected $table = "products";

    public function showAll(){
      
        $query=$this->db->prepare ('SELECT * FROM products limit 31');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    
        }


}
?>