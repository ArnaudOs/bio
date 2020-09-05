<?php
  

    function insOrder($panier, $nom, $prenom, $mail, $phone, $address, $livraison, $pay)
    {
        $db = new PDO("mysql:host=db5000849816.hosting-data.io;dbname=dbs748890;charset=utf8", "dbu976781","Basebeebee270*", [
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

    insOrder($panier, $nom, $prenom, $mail, $phone, $address, $livraison, $pay)

?>