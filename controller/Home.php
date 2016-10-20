<?php
	require_once("model/data.php");

	class Home
  {

		function __construct()
    {

		}


    // ACTIONS DU CONTROLEUR //
    // Affichage de la page d'accueil
    function index()
    {
			$data = new Data();
			$data->content = "homeView.php";
			$data->menu['Home'] = "index.php";
			$data->menu['A propos'] = "index.php?controller=Home&action=apropos";
			$data->menu['Voir photos'] = "index.php?controller=Photo";
			require_once("view/mainView.php");
    }

    // Affichage du "à propos"
    function apropos()
    {
			$data = new Data();
			$data->content = "aProposView.php";
			$data->menu['Home'] = "index.php";
			$data->menu['A propos'] = "index.php?controller=Home&action=apropos";
			$data->menu['Voir photos'] = "index.php?controller=Photo";
			require_once("view/mainView.php");
    }
}
