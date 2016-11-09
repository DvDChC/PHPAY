<?php
	  require_once("model/userDAO.php");
    require_once("model/data.php");

  	class Logout {
      public $data;

  		function __construct() {
        $this->data = new data();
  		}

  		function index() {
  			$_SESSION = array();
        session_destroy();
        header('Location: index.php');
  		}

  		private function setMenu()
		{
			$this->data->content = "homeView.php";
			$this->data->menu['Home'] = "index.php";
			$this->data->menu['A propos'] = "index.php?controller=Home&action=apropos";
			$this->data->menu['Voir photos'] = "index.php?controller=Photo&imgId=1";
			require_once("view/mainView.php");
			
		}
  	}

?>