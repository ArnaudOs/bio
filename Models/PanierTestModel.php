<?php
require_once 'Model.php';
require_once('vendor/autoload.php');
// require('vendor/phpmailer/phpmailer/src/PHPMailer.php');
// require('vendor/phpmailer/phpmailer/src/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
// // use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
// use League\OAuth2\Client\Provider\Google;

class PanierTestModel extends Model{

    protected $table = 'products';
    
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
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
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
    $query->fetch(PDO::FETCH_OBJ);
    }

    public function insertOrder ($panier, $nom, $prenom,$mail,$phone,$address,$livraison){
      
     
    //3. on insère la nouvelle commande
        $query = $this->db->prepare('
        INSERT INTO orders_bee SET
        nom = :nom,
        prenom= :prenom,
        phone = :phone,
        address=:address,
        mail=:mail,
        livraison=:livraison
        ');
        $query->execute(compact('phone', 'address','nom','prenom','mail','livraison'));

    $orders_id = $this->db->lastInsertID();


    $query = $this->db->prepare('
    INSERT into orders SET

    orders_id=:orders_id,
    product_id=:product_id,
    quantity=:quantity,
    price=:price
    ');
 
        // for ($i=0; $i<count($panier); $i++){
        //     foreach ($panier as $id => $element) {
        //     $price = $element['product']->price;
        //     $quantity = $element['quantity'];
        //     $product_id = $id;
        //     $query->execute(compact('orders_id', 'product_id', 'quantity','price'));
        // // }
           
            // var_dump($element);
       
    }
 
    //5 ppour chaque produit du panier
  

        public function mailOrders($email,$newUser, $panier){
            $tabloHTML = "
<html>
<head>

   <style>
   body, table { 
    font-family : Arial, Helvetica,
    sans-serif;
    } 
    caption { font-family : Arial, Helvetica,
    sans-serif; font-size : 18px; padding-bottom:1%;
    text-align:left; 
    }

    th {
    background:#2c3e50; color:white;
    font-size : 14px; text-align: center;
    }
    
    table { 
    border-width:1px; border-style:solid;
    border-color:black; border-collapse:collapse;
    }
    th, td {
    border:1px; border-style:solid;
    border-color:white; text-align: center; width:100px;
    } 
    td {
    font-size : 12px;
    height:10px;
    }
    tr:nth-child(odd){ 
    background:#ecf0f1;
    } 
    td:first-child {
    width:130px; 
    }
    </style>
   
</head>
<body>

 
   <table>
   <caption>votre commande</caption>
    <tr>
        <thead>
        <th>produit</th>
        <th>quantité</th>
        <th>prix</th>
        <th>total</th>
        </thead>
    </tr>
    <tbody>{{tablo}}
    </tbody>
    </table>
</body>
</html>";
         
            
            $tabl = "";
        
            foreach ($panier as $element) {
                $tabl .= "<tr>";
        
                $tabl .= "<td>"  . $element['product']->title ." </td> ";
                $tabl.= " <td> " .  $element['quantity'] ." </td> ";
                $tabl.=  " <td> " .  $element['product']->price . "€" . "</td> ";
                $tabl.=  " <td> " . $element['quantity'] * $element['product']->price . "€" . "</td>";
                $tabl .= "</tr>";
            }
           
    

            $tablo= str_replace("{{tablo}}", $tabl, $tabloHTML);
            $mail= new PHPmailer();
            $mail->CharSet = "UTF-8";
            $mail->isHTML(true);
            // $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
            $mail->Host = 'smtp.ionos.fr'; // Spécifier le serveur SMTP
            $mail->SMTPAuth = true; // Activer authentication SMTP
            // $mail->Username = 'contact@beebeelogis.fr'; // Votre adresse email d'envoi
            // $mail->Password = 'Admincontact83*!'; // Le mot de passe de cette adresse email
            $mail->Username = 'contact@webdevsolution.fr'; // Votre adresse email d'envoi
            $mail->Password = 'Adminmaster**!27!'; // Le mot de passe de cette adresse email
          
            $mail->SMTPSecure = 'tls'; // Accepter SSL
            $mail->Port = 587;
            
    
            $mail->setFrom($email, $newUser); // Personnaliser l'envoyeur
            // $mail->addAddress('contact@beebeelogis.fr', 'contact'); // Ajouter le destinataire
            $mail->addAddress('contact@webdevsolution.fr', 'contact'); // Ajouter le destinataire
            $mail->addReplyTo($email, 'Information'); // L'adresse de réponse
            $mail->addCC('beebeelogis@gmail.com');
            // $mail->addBCC('bcc@example.com');
    
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Ajouter un attachement
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 
            // Paramétrer le format des emails en HTML ou non
    
            $mail->Subject = 'votre commande';
            $mail->Body = 'Bonjour ' . $newUser . ' et merci pour votre commande ' . $tablo;
            // $mail->AltBody = 'Bienvenue et merci pour votre commande';
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            } 
    }

}


   
