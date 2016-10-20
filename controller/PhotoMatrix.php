<?php
	require_once("model/imageDAO.php");

	class PhotoMatrix {

		protected $imageDAO;

		function __construct() {
      $this->imageDAO = new ImageDAO();
		}


    // ACTIONS DU CONTROLEUR //
    // Action par défaut
    function index()
    {

    }
    // Affichage à partir de l'image 1
    function first()
    {

    }

    // Affichage des n images suivantes
    function next()
    {

    }

    // Affichage des n images précédentes
    function prev()
    {

    }

    // Affichage d'une matrice d'images à partir d'une image aléatoire
    function random()
    {

    }

    // Affiche 2x plus d'images
    function more()
    {

    }

    // Affiche 2x moins d'images
    function less()
    {

    }
}
