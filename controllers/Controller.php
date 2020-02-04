<?php


abstract class Controller
{
    
    protected $model;

   
    protected $modelName;

  
    public function __construct()
    {
     
        if (empty($this->modelName)) {
            throw new Exception('Vous avez oublié de fournir un <em>protected $modelName</em> dans la classe ' . get_called_class() . " hors il est obligatoire de fournir le nom du Model à utiliser !");
        }

        $chemin = "Models/{$this->modelName}.php";
    
        if (!file_exists($chemin)) {
            throw new Exception("Le model défini dans " . get_called_class() . " ({$this->modelName}) n'existe pas ! Nous n'avons pas trouvé le fichier qui aurait du se trouver ici : $chemin !");
        }

        require_once $chemin;
        $this->model = new $this->modelName();
       
    }

    /**
     * @param string
     * @param array 
     * @return void
     */
    protected function view(string $template, array $variables = [])
    {
       
        extract($variables);

    
        require_once 'templates/partials/header.phtml';

        require_once "$template.phtml";
  
        // require_once 'templates/partials/footer.phtml';
  
    }

    /**
     * Permet de rediriger vers une $url avec un $message d'erreur
     *
     * @param string $url
     * @param string $message
     * @return void
     */
    protected function redirectWithError(string $url, string $message)
    {
        Session::addFlash('error', $message);
        Http::redirect($url);
    }

    /**
     * Permet de rediriger vers une $url avec un $message de succès
     *
     * @param string $url
     * @param string $message
     * @return void
     */
    protected function redirectWithSuccess(string $url, string $message)
    {
        Session::addFlash('success', $message);
        Http::redirect($url);
    }
  
    /**
     * Permet de rediriger vers la page précédente avec un $message d'erreur
     *
     * @param string $message
     * @return void
     */
    protected function redirectBackWithError(string $message)
    {
        $url = $_SERVER['HTTP_REFERER'];
        $this->redirectWithError($url, $message);
    }

    /**
     * Permet de rediriger vers la page précédente avec un $message de succès
     *
     * @param string $message
     * @return void
     */
    protected function redirectBackWithSuccess(string $message)
    {
        $url = $_SERVER['HTTP_REFERER'];
        $this->redirectWithSuccess($url, $message);
    }
}
?>