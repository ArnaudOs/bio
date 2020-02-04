<?php
require_once 'Http.php';
class Request
{
    
    const EMAIL = FILTER_VALIDATE_EMAIL;

    const INT = FILTER_VALIDATE_INT;

     const SAFE = FILTER_SANITIZE_SPECIAL_CHARS;

   
    public static function get(string $name, int $filter = FILTER_DEFAULT)
    {
        // On essaye d'extraire à partir du POST
        $value = filter_input(INPUT_POST, $name, $filter);

        // Si on ne la trouve pas dans le POST on essaye avec le GET
        if (!$value) {
            $value = filter_input(INPUT_GET, $name, $filter);
        }

        // On retourne la valeur
        return $value;
    }
 
    public static function redirectIfNotSubmitted(string $url)
    {
        if (empty($_POST)) {
            Http::redirect($url);
        }
    }
    public static function redirectIfNotAdmin()
{
    Session::isConnected();
    if (!$_SESSION['user']['admin'] == 1) {
        Http::redirect('index.php?controller=Users&task=formLogin');
    }
}
}

