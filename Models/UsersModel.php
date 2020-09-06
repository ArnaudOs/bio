<?php
require_once "Model.php";

require_once('vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class UsersModel extends Model
{
    protected $table = "users";


    public function findByEmail(string $email)
    {
        $query = $this->db->prepare('
            SELECT * FROM users WHERE email = :email
        ');

        $query->execute([
            ':email' => $email,
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }


    public function insertUsers($nom, $prenom, $email, $hash)
    {
 
        $query = $this->db->prepare('INSERT INTO users SET
    nom=:nom,
    prenom=:prenom,
    email= :email,
    password= :password
    ');
        $query->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => $hash
        ]);
    }
    public function contact($nom,$prenom,$email,$sujet, $msg){

        $mail= new PHPmailer();
        $mail->CharSet = "UTF-8";
        // $mail->IsHTML(true);
        $mail->IsSMTP();
       // Paramétrer le Mailer pour utiliser SMTP 
        $mail->Host = 'smtp.ionos.fr'; // Spécifier le serveur SMTP
        $mail->SMTPAuth = true; // Activer authentication SMTP
        // $mail->Username = 'contact@beebeelogis.fr'; // Votre adresse email d'envoi
        // $mail->Password = 'Admincontact83*!'; // Le mot de passe de cette adresse email
        $mail->Username = 'contact@beebeelogis.fr'; // Votre adresse email d'envoi
        $mail->Password = 'Monmailcontact83**'; // Le mot de passe de cette adresse email
    
        $mail->SMTPSecure = 'tls'; // Accepter SSL
        $mail->Port = 587;
        

        $mail->setFrom($email, $nom,$prenom); // Personnaliser l'envoyeur
        // $mail->addAddress('contact@beebeelogis.fr', 'contact'); // Ajouter le destinataire
        $mail->addAddress('contact@beebeelogis.fr'); // Ajouter le destinataire
        $mail->addReplyTo($email, 'client'); // L'adresse de réponse
        $mail->addCC('beebeelogis@gmail.com');
        // $mail->addBCC('bcc@example.com');

        // $mail->addAttachment('/var/tmp/file.tar.gz'); // Ajouter un attachement
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 
        // Paramétrer le format des emails en HTML ou non

        $mail->Subject = $sujet;
        $mail->Body = $msg;
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
