<?php
    // require('Session.php');
    // require('Http.php');
    // $panier=$_SESSION['panier'];

    // $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
    // $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
    // $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_SPECIAL_CHARS);
    // $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    // $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    // $livraison = filter_input(INPUT_POST, 'livraison', FILTER_SANITIZE_SPECIAL_CHARS);
    // $pay = filter_input(INPUT_POST, 'pay');

    function insOrder($panier, $nom, $prenom, $mail, $phone, $address, $livraison, $pay)
    {
        $db = new PDO("mysql:host=localhost;dbname=beebee;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        //3. on insère la nouvelle commande
        $query = $db->prepare("
                        INSERT INTO orders_bee SET
                        nom =:nom,
                        prenom=:prenom,
                        phone =:phone,
                        address=:address,
                        mail=:mail,
                        livraison=:livraison,
                        pay_choose=:pay
                        ");
        //    $query->execute([
        //         ':nom'=>$nom,
        //         ':prenom'=>$prenom,
        //         ':phone'=>$phone,
        //         ':mail'=>$mail,
        //         ':address'=>$address,
        //         ':livraison'=>$livraison,
        //         ':pay'=>$pay
        //         ]);
        // $query->execute('phone', 'address','nom','prenom','mail','livraison','pay');
        $query->execute(compact('phone', 'address', 'nom', 'prenom', 'mail', 'livraison', 'pay'));

        $orders_id = $db->lastInsertID();

        $queryO = $db->prepare('
        INSERT into orders SET

        orders_id=:orders_id,
        product_id=:product_id,
        quantity=:quantity,
        price=:price
        ');

        foreach ($panier as $id => $element) {
            $price = $element['product']->price;
            $quantity = $element['quantity'];
            $product_id = $id;
            $queryO->execute(compact('orders_id', 'product_id', 'quantity', 'price'));
        }
    }
//  insertOrder($panier, $nom, $prenom,$mail,$phone,$address,$livraison, $pay);
//   $_SESSION['panier']=[];
//  Http::redirect('../index.php?controller=PanierTest&task=showOrder');


?>