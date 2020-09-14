<?php
require_once "configuration.php";
class UsersController extends Controller{

    protected $modelName = 'UsersModel';


// On affiche le panneau administrateur
public function adminBoard(){
    Request::redirectIfNotAdmin();
    $this->view('templates/admin/admin');
}
 // On affiche le template inscription il sera supprimé à terme
    public function showRegister()
    {
        // Request::redirectIfNotAdmin();
        $this->view('templates/formulaire-inscription');
    }
// On affiche le template pour la connexion administrateur uniquement
    public function formLogin()
    {
  
        $this->view('templates/connect');
    }

//cette fonction ne sert plus il n'y a aura pas de nouveaux utilisateurs
    public function saveUsers()
    {
        Request::redirectIfNotSubmitted('index.php');

   
        $email = Request::get('email', Request::EMAIL);
$nom = Request::get('nom', Request::SAFE);
$prenom = Request::get('prenom', Request::SAFE);
$password = Request::get('password');
$hash = password_hash($password, PASSWORD_DEFAULT);
$passwordConfirm = Request::get('passwordconfirm', Request::SAFE);

        if (!$email || !$nom || !$prenom || !$password || !$passwordConfirm)  {
            $this->redirectBackWithError("Votre formulaire n'était pas complet !");
        }

        $user = $this->model->findByEmail($email);


        if ($user) {
            $this->redirectBackWithError("Un compte existe déjà avec cette adresse email");
        }

        if ($password != $passwordConfirm) {
            $this->redirectBackWithError("Les deux mots de passe fournis ne correspondent pas !");
        }

        $password = password_hash($password, PASSWORD_DEFAULT);


        $this->model->insertUsers($nom, $prenom, $email, $hash);

        $this->redirectWithSuccess(
            "index.php?controller=Users&task=formLogin",
            "Vous pouvez désormais vous connecter!"
        );
    }

// fonction de connexion 
    public function login()
    {
      
        Request::redirectIfNotSubmitted('index.php');

        $email = Request::get('email', Request::EMAIL);
        $password = Request::get('password');

        if (!$email || !$password) {
            $this->redirectBackWithError("Le formulaire a été mal rempli");
        }

        $user = $this->model->findByEmail($email);

        if (!$user) {
            $this->redirectBackWithError("Aucun compte utilisateur ne possède cette adresse email");
        }
 
        $correspondance = password_verify($password, $user['password']);

        if (!$correspondance) {
            $this->redirectBackWithError("Le mot de passe ne correspond au compte utilisateur trouvé");
        }

        Session::connect($user);
       
        if ($_SESSION['user']['admin'] == 1 || $_SESSION['user']['admin'] == 2) {
            Session::addFlash('success', "Bienvenue administrateur");
            Http::redirect('index.php?controller=Users&task=adminBoard');
        }
        $this->redirectWithSuccess(
            "index.php",
            "Bonjour <strong>$user[prenom]</strong>, vous êtes désormais connecté(e)"
        );
    }

// fonction de deconnexion 
    public function logout()
    {
        Session::disconnect();

        $this->redirectWithSuccess(
            "index.php",
            "Vous êtes désormais déconnecté !"
        );
  
}

    public function showContact(){

        $this->view('templates/contact');
    
    }

    public function sendMailContact(){
    
    
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
        $sujet = filter_input(INPUT_POST, 'sujet', FILTER_SANITIZE_SPECIAL_CHARS);
        $msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);
        // include_once("libraries/contact.php");
        $this->model->contact($nom,$prenom,$email,$sujet, $msg);
    }
}
?>