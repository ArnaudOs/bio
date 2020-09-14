<?php
   require_once('vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    function  contactMail($nom,$prenom,$email,$sujet, $msg){
        // $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        // $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        // $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        // $sujet = filter_input(INPUT_POST, 'sujet', FILTER_SANITIZE_SPECIAL_CHARS);
        // $msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);

        $mail= new PHPmailer();
        $mail->CharSet = "UTF-8";
        $mail->IsHTML(true);
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
            Session::addFlash('success',' Votre message a été envoyée a Beebee ');
        } 

    }

    contactMail($nom,$prenom,$email,$sujet, $msg);

?>