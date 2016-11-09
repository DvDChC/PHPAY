<?php
	 require_once("model/userDAO.php");
  	require_once("model/data.php");

  	$userDAO = new userDAO();

  	$uname = $_POST["uname"];
  	$pwd = $_POST["pwd"];

    //var_dump($_POST);

  	if (isset($_POST['login']) && $userDAO->userLogin($uname, $pwd)) {
  		$_SESSION['login'] = $uname;
      $_SESSION['id'] = $userDAO->userLogin($uname, $pwd)->getId();
  	}

    if (isset($_POST['signin']) && $userDAO->createUser($uname, $pwd)) {
      $_SESSION['login'] = $uname;
    }

  	class Login {
  		public $data;
  		private $userDAO;

  		function __construct() {
  			$this->data = new data();
  			$this->userDAO = new userDAO();
  		}

  		function index() {
  			$this->setMenu();
  			require_once("view/mainView.php");
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