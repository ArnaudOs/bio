<?php
require_once "Model.php";
class AdminModel extends Model{

    protected $table = "products";


    public function showProduct(){

        $query = $this->db->prepare("SELECT * FROM `products` ORDER BY id");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
                }


    public function insertProd($fileName, $price, $imagetitle) {
   
        $query = $this->db->prepare('INSERT INTO products SET
        title = :title,
        price =:price,
        img_name = :img_name');
        $query->execute([
            ':title' => $imagetitle,
            ':price' => $price,
            ':img_name' => $fileName
        ]);
    }

    public function findImgProd(int $id) {
        $query = $this->db->prepare('
        SELECT * FROM products WHERE id=:id
        ');
        $query->execute(['id' => $id]);

        return $query->fetch(PDO::FETCH_ASSOC);

    }

    public function updateImageProd($filename, $id, $price, $imagetitle){
        $query = $this->db->prepare('UPDATE products SET
        img_name = :img_name,
        title = :title,
        price =:price
        WHERE products.id=:id');
        $query->execute([
            ':img_name' => $filename,
            ':id' => $id,
            ':title' => $imagetitle,
            ':price' => $price,
        ]);
    }
}
?>