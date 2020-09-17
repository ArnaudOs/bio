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
    
    // protected static $pdo;

    // public static function getInstance()
    // {
    //     if (empty(self::$pdo)) {
    //         self::$pdo = new pdo(
    //             'mysql:host=localhost;dbname=beebee;charset=utf8',
    //             'root',
    //             '',
    //             [
    //                 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    //             ]
    //         );

    //     }
    //     return self::$pdo;
    // }
    
    public function showProduct(){

        $query = $this->db->prepare("SELECT * FROM `products`");
        $query->execute();
        return $query->fetchALL(PDO::FETCH_ASSOC);
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
    return $query->fetch(PDO::FETCH_OBJ);
    }


    public function test($nom, $prenom,$mail,$phone,$address,$livraison, $pay){
        $q = $this->db->prepare("
        INSERT INTO orders_bee SET
        nom =:nom,
        prenom=:prenom,
        phone =:phone,
        address=:address,
        mail=:mail,
        livraison=:livraison,
        pay_choose=:pay");
        $q->execute(compact('phone', 'address','nom','prenom','mail','livraison','pay'));

    }

    // public function insertOrder ( $nom, $prenom,$mail,$phone,$address,$livraison, $pay){
        public function insertOrder ($panier, $nom, $prenom,$mail,$phone,$address,$livraison, $pay){
            
    //3. on insère la nouvelle commande
        $query = $this->db->prepare("
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
        $query->execute(compact('phone', 'address','nom','prenom','mail','livraison','pay'));
        // $_SESSION['panier']=[];
         for ($i=0; $i<count($panier); $i++){
            $orders_id = $this->db->lastInsertID();
            $queryOrders = $this->db->prepare('
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
            $queryOrders->execute(compact('orders_id', 'product_id', 'quantity','price'));
             }
        }     
//             var_dump($element);
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
    background:#82ae46;; color:white;
    font-size : 14px; text-align: center;
    }
    
    table { 
    border-width:1px; border-style:solid;
    border-color:black; border-collapse:collapse;
    }
    th, td {
    border:1px; border-style:solid;
    border-color:white; text-align: center; width:120px;
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
            $total =0;
            foreach ($panier as $element) {
                $tabl .= "<tr>";
        
                $tabl .= "<td>".$element['product']->title." </td> ";
                $tabl.= "<td>".$element['quantity']."</td>";
                $tabl.=  "<td>".$element['product']->price." €"."</td>";
           
                $total+= $element['quantity'] * $element['product']->price;
             
                $tabl .= "</tr>";
            }
            $tabl.= "<tr>";
            $tabl.= "<td  colspan='1' class='total'>Total commande : <strong>" .$total . " €"  ."</strong></td>";
            $tabl.= "</tr>";
    

            $tablo= str_replace("{{tablo}}", $tabl, $tabloHTML);
            $mail= new PHPmailer();
            $mail->CharSet = "UTF-8";
            $mail->isHTML(true);
            $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
            $mail->Host = 'smtp.ionos.fr'; // Spécifier le serveur SMTP
            $mail->SMTPAuth = true; // Activer authentication SMTP
            $mail->Username = 'contact@beebeelogis.fr'; // Votre adresse email d'envoi
            $pass='Monmailcontact83**';
            $mail->Password = $pass; // Le mot de passe de cette adresse email
            // $mail->Username = 'contact@webdevsolution.fr'; // Votre adresse email d'envoi
            // $mail->Password = 'Adminmaster**!27!'; // Le mot de passe de cette adresse email
          
            $mail->SMTPSecure = 'tls'; // Accepter SSL
            $mail->Port = 587;
            
    
            $mail->setFrom('contact@beebeelogis.fr', 'contact'); // Personnaliser l'envoyeur
            $mail->addAddress($email); // Ajouter le destinataire
            $mail->addReplyTo('contact@beebeelogis.fr', 'contact'); // L'adresse de réponse
            // $mail->addCC('beebeelogis@gmail.com');
            $mail->addBCC('beebeelogis@gmail.com');
    
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Ajouter un attachement
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 
            // Paramétrer le format des emails en HTML ou non
    
            $mail->Subject = 'votre commande<br>';
            $mail->Body = 'Bonjour ' . $newUser . ' et merci pour votre commande' . $tablo . "<br>";
            // $mail->AltBody = 'Bienvenue et merci pour votre commande';
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            if(!$mail->send()) {
                echo 'Message non envoyé';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                Session::addFlash('success',' Votre commande a été envoyée a Beebee ');
            } 
            // $panier="";
            // $_SESSION=[];
    }
    

}


   
