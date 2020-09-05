<?php


abstract class Model
{
    protected $db;

     
    protected $table;

    

    public function __construct()
    {
        if (empty($this->table)) {
            throw new Exception('Vous devez absolument spécifier une propriété protected $table dans votre classe qui hérite de Model et qui contient le nom de la table à attaquer.');
        }

        $this->db = new PDO("mysql:host=localhost;dbname=beebee;charset=utf8", "root","",[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }


    public function find(int $id)
    {

        $query = $this->db->prepare("SELECT * FROM $this->table WHERE id = :id");
        $query->execute([
            ':id' => $id,
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Permet de récupérer la liste des données
     *
     * @return array
     */
    public function findAll() : array
    {
        // Retourner tous les articles
        $query = $this->db->prepare("SELECT * FROM $this->table");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Permet d'insérer un nouvel enregistrement et retourne l'identifiant
     *
     * @param array $data
     * @return integer
     */
    public function insert(array $data)
    {
        $sql = "INSERT INTO $this->table SET ";

        $columns = array_keys($data);
        $sqlColumns = [];

        foreach ($columns as $column) {
            $sqlColumns[] = "$column = :$column";
        }

        $sql .= implode(",", $sqlColumns);

        $query = $this->db->prepare($sql);

        $query->execute($data);

        // return $this->db->lastInsertId();
    }


    public function update(array $data)
    {
        if (!array_key_exists('id', $data)) {
            throw new Exception("Vous ne pouvez pas appeler la fonction update sans préciser dans votre tableau un champ `id` !");
        }

        $sql = "UPDATE $this->table SET ";

        $columns = array_keys($data);
        $sqlColumns = [];

        foreach ($columns as $column) {
            $sqlColumns[] = "$column = :$column";
        }

        $sql .= implode(",", $sqlColumns);

        $sql .= " WHERE id = :id";

        $query = $this->db->prepare($sql);

        $query->execute($data);
    }

    /**
     * Permet de supprimer un enregistrement
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $query = $this->db->prepare("DELETE FROM $this->table WHERE id = :id");

        $query->execute(['id' => $id]);
    }
}

?>