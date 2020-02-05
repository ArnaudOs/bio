<?php
require_once "Model.php";
class ShopModel extends Model{

    protected $table = "save_resultats";

    public function showAll(){
      
        $query=$this->db->prepare ('SELECT * FROM save_resultats limit 31');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    
        }


}
?>