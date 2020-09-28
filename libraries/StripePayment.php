<?php
namespace PhpStripe\Service;

// require_once 'vendor/stripe/autoload.php';
// require_once('vendor/autoload.php');
require_once ('vendor/stripe/stripe-php/init.php');

use PDO;
use \Stripe\Stripe;
use \Stripe\Customer;
use \Stripe\ApiOperations\Create;
use \Stripe\Charge;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class StripePayment
{

    private $apiKey;

    private $stripeService;


    public function __construct()
    {
        // define("STRIPE_SECRET_KEY", "sk_test_2t7HjFL7wL3rvd0hsjqzlLoy00PexoyNuq");
        // define("STRIPE_PUBLISHABLE_KEY", "pk_test_pSDfxSHmMJLvrK425WZaqfs000CIJPkZ9n");
        $this->apiKey = STRIPE_SECRET_KEY;
        $this->stripeService = new \Stripe\Stripe();
        $this->stripeService->setVerifySslCerts(false);
        $this->stripeService->setApiKey($this->apiKey);
    }

    public function addCustomer($customerDetailsAry)
    {
        
        $customer = new Customer();
        
        $customerDetails = $customer->create($customerDetailsAry);
        
        return $customerDetails;
    }

    public function showLastUsers(){
        $this->db = new PDO("mysql:host=localhost;dbname=beebee;charset=utf8", "root","",[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
        // $query = $this->db->prepare("SELECT id_orders, total FROM orders_bee ORDER BY id_orders DESC LIMIT 0, 1");
        $query = $this->db->prepare("SELECT * FROM orders_bee ORDER BY id_orders DESC LIMIT 0, 1");
        $query->execute();
        $total=$query->fetchAll(PDO::FETCH_ASSOC);
        return $total;
        
    }

    public function mailStripe($customerDetailsAry, $total){
        $mail= new PHPmailer();
        $mail->isSMTP(); // Paramétrer le Mailer pour utiliser SMTP 
        $mail->Host = 'smtp.ionos.fr'; // Spécifier le serveur SMTP
        $mail->SMTPAuth = true; // Activer authentication SMTP
        $mail->Username = 'contact@beebeelogis.fr'; // Votre adresse email d'envoi
        $pass ="Beebeecontact270**";
        $mail->Password = $pass; // Le mot de passe de cette adresse email
        $mail->SMTPSecure = 'tls'; // Accepter SSL
        $mail->Port = 587;

        $mail->setFrom($customerDetailsAry['email']); // Personnaliser l'envoyeur
        $mail->addAddress('contact@beebeelogis.fr', 'contact'); // Ajouter le destinataire
        $mail->addReplyTo($customerDetailsAry['email'], 'Information'); // L'adresse de réponse
        $mail->addCC('arnaud.osenda@gmail.com');
        
        $mail->isHTML(true); // Paramétrer le format des emails en HTML ou non

        $mail->Subject = 'Paiement effectue';
        $mail->Body = 'Bienvenue et merci pour votre commande ' . $total ;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        if (!$mail->send()) {
            echo "Mailer Error: ". $mail->ErrorInfo; echo "<br>"; echo "<br>"; 
        }   
        else {
            echo "Le règlement a bien été effectué un mail de confirmation vous a été envoyé"; 
    }
        exit; 
}


    public function chargeAmountFromCard($cardDetails)
    {   
        
        $total=$this->showLastUsers();
        // var_dump($price);
        $customerDetailsAry = array(
            'email' => $cardDetails['email'],
            'source' => $cardDetails['token']
        );
        $customerResult = $this->addCustomer($customerDetailsAry);
        $charge = new Charge();
        $cardDetailsAry = array(
            'customer' => $customerResult->id,
            // 'amount' => $cardDetails['amount']*100 ,
            'amount' => $total[0]['total']*100,
            // 'amount' => $price[0]['pay_client'],
            // 'currency' => $cardDetails['currency_code'],
            'currency' => 'eur',
            'description' => $cardDetails['item_name'],
            'metadata' => array(
                'order_id' => $cardDetails['item_number']
            )
        );
        $result = $charge->create($cardDetailsAry);
        return $result->jsonSerialize();
        $this->mailStripe($customerDetailsAry, $total);

    }

     
       
}