<?php
require_once("libraries/Database.php");
//1.connexion à la base de données
$pdo = Database::getInstance();

//2. requête qui va chercher la lsite des plats
$query = $pdo->prepare('SELECT * FROM plats');
$query->execute();
$plats = $query->fetchAll(PDO::FETCH_OBJ);
//affichage
?>


<h1>Les plats</h1>
<?php foreach ($plats as $plat) : ?>
    <h3><?= $plat->nom_plat ?> (<?= $plat->prix ?> €) </h3 >

<form action="add-panier.php" method="POST">
    <input type="hidden" name="id" value="<?= $plat->id ?>">
    <input type="number" name="quantity" id="" placeholder="quantité" required="required" min="1" size="3">
    <button type="submit">Ajouter au panier</button>
</form>
<?php endforeach ?>