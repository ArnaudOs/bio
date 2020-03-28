<?php
// require_once "Model.php";


class PanierModel extends Model{

    protected $table = "products";
    
    protected static $pdo;

    public static function getInstance()
    {
        if (empty(self::$pdo)) {
            self::$pdo = new pdo(
                'mysql:host=localhost;dbname=beebee;charset=utf8',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );

        }
        return self::$pdo;
    }

    public function findProducts(): array
    {
        $query = $this->db->prepare('
           
        SELECT * FROM products
        ');
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    public function addingPanier($id){
       
        $query = $this->db->prepare('SELECT*FROM products WHERE id=:id');
        $query->execute([':id' => $id]);//on peut ne pas mettre les deux points dans le token en execute 'id'
        $query->fetch(PDO::FETCH_ASSOC);
    }

   
}
   
?>