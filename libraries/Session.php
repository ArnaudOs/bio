<?php

session_start();
class Session

/**
 * Permet de savoir si l'utilisateur est connecté
 */
{

    public static function isConnected() : bool
    {
        return !empty($_SESSION['connected']);
    }


    /**
     * Permet de mettre en palce la session pour un utilisateur donné
     *
     * @param array $user
     * @return void
     */
    public static function connect(array $user)
    {
        $_SESSION['connected'] = true;
        $_SESSION['user'] = $user;

    }
    /**
     * Permet de supprimer les infos de la connexion dans la session
     *
     * @param array $user
     * @return void
     */
    public static function disconnect()
    {
        $_SESSION['connected'] = false;
        $_SESSION['user'] = null;

    }
    /**
     * Permet d'ajouter un message flash
     *
     * @param string $type
     * @param string $message
     * @return void
     */
    public static function addFlash(string $type, string $message)
    {
        if (empty($_SESSION['messages'])) {

            $_SESSION['messages'] = [
                'error' => [],
                'success' => [],
            ];
        }
        $_SESSION['messages'][$type][] = $message;
    }
    /**
     * Permet de récuperer  les messages d'un certain type
     *
     * @param string $type
     * @return void
     */
    public static function getFlashes(string $type)
    {

        if (empty($_SESSION['messages'])) {
            return [];
        }
        $messages = $_SESSION['messages'][$type];
        $_SESSION['messages'][$type] = [];
        return $messages;
    }

    /**
     * Permet de savoir s'il ya des messages d'erreurs
     *
     * @param string $type
     * @return boolean
     */
    public static function hasFlashes(string $type) : bool
    {

        if (empty($_SESSION['messages'])) {
            return false;
        }
        return (!empty($_SESSION['messages'][$type]));
    }
}
?>