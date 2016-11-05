<?php
	require_once("model/data.php");

	class Home
  {
		public $data;

		function __construct()
    {
			$this->data = new Data();
		}


    // ACTIONS DU CONTROLEUR //
    // Affichage de la page d'accueil
    function index()
    {

			$this->data->content = "homeView.php";
			$this->data->menu['Home'] = "index.php";
			$this->data->menu['A propos'] = "index.php?controller=Home&action=apropos";
			$this->data->menu['Voir photos'] = "index.php?controller=Photo&imgId=1";
			require_once("view/mainView.php");
    }

    // Affichage du "à propos"
    function apropos()
    {
			$this->data->content = "aProposView.php";
			$this->data->menu['Home'] = "index.php";
			$this->data->menu['A propos'] = "index.php?controller=Home&action=apropos";
			$this->data->menu['Voir photos'] = "index.php?controller=Photo&imgId=1";
			require_once("view/mainView.php");
    }
}
