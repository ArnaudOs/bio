<?php
class Http
{

    public static function redirect(string $url)
    {
        header("Location: $url");
        exit();
    }
    /**
     * pERMET DE REDIRIGER VERS LA PAGE PRÉCÉENTE
     *
     * @return void
     */
    public static function redirectBack()
    {
        self::redirect($_SERVER['HTTP_REFERER']);
    }
}

?>