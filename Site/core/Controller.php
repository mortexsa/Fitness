<?php
class Controller{
	public $request;             // Objet Request
	private $vars = array();     // Variables à passer à la vue
	public $layout = 'default';  // Layout à utiliser pour rendre la vue
	private $rendered = false;   // Si le rendu à été fait ou pas ?

    /**
     * Controller constructor.
     * @param $request -Objet request de notre application
     */
	function __construct($request){
		$this->request = $request;
	}

    /**
     * Permet de rendre une vue
     * @param $view -fichier à rendre (chemin depuis view ou nom de la vue)
     * @return bool
     */
	public function render($view){
		if($this->rendered){ return false; }
		extract($this->vars);
		if(strpos($view,'/')===0){
			$view = ROOT.DS.'view'.$view.'.php';
		}else{
			$view = ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
		}
		ob_start();
		require($view);
		$content_for_layout = ob_get_clean();
		require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php';
		$this->rendered = true;
	}

    /**
     * Permet de passer une ou plusieurs variable à la vue
     * @param $key -nom de la variable OU tableau de variables
     * @param $value -Valeur de la variable
     */
	public function set($key, $value=null){
		if (is_array($key)) {
			$this->vars += $key;
		}
		else {
			$this->vars[$key] = $value;	
		}
	}

    /**
     * Charge le model
     * @param $name
     */
	/*function loadModel($name)
    {
        $file = ROOT.DS.'model'.DS.$name.'.php';
        require_once($file);
        if (!isset($this->$name)) {
            $this->$name = new $name();
        } else {
            echo 'Pas charger.';
        }
    }*/
}


?>