<?php
	require_once("model/imageDAO.php");
  require_once("model/data.php");

	class Photo {

		protected $imageDAO;
		public $data;

		function __construct() {
      $this->imageDAO = new ImageDAO();
			$this->data = new Data();
		}


    // ACTIONS DU CONTROLEUR //
    // Action par défaut
    function index()
    {
			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				return $this->first();
			}

			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			$this->data->size = $size;
			$this->data->imgId = $id;
			$this->data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$this->data->content = "photoView.php";

			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage de la photo n°1.
    function first()
    {
			$id = 1;

			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			$this->data->size = $size;
			$this->data->imgId = 1;

			$this->data->imageURL = $this->imageDAO->getFirstImage()->getPath();
			$this->data->content = "photoView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage de l'image suivante
    function next()
    {
			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			// Si on ne peut plus augmenter, boucle sur la 1ere
			if($id < $this->imageDAO->size()){
				$id++;
			}else{
				$id = 1;
			}

			$this->data->size = $size;
			$this->data->imgId = $id;

			$this->data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$this->data->content = "photoView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage de l'image précédente
    function prev()
    {
			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			// Si on ne peut plus diminuer, boucle sur la dernière
			if($id > 1){
				$id--;
			}else{
				$id = $this->imageDAO->size();
			}

			$this->data->size = $size;
			$this->data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$this->data->imgId = $id;
			$this->data->content = "photoView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage d'une image aléatoire
    function random()
    {
			// tire un ID au hasard
			$id = $this->imageDAO->getRandomImage();

			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			$this->data->size = $size;
			$this->data->imgId = $id;
			$this->data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$this->data->content = "photoView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Zoom sur l'image
    function zoomIn()
    {
			// récupère la taille
			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			// récupère l'id
			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			$this->data->size = $size*1.25;

			// force la taille maximale à 1000px
			if($this->data->size > 1000){
				$this->data->size = 1000;
			}

			$this->data->imgId = $id;
			$this->data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$this->data->content = "photoView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Dézoom de l'image
    function zoomOut()
    {
			// récupère la taille
			if(isset($_GET['size'])){
				$size = $_GET['size'];
			}else{
				$size = 480;
			}

			// récupère l'id
			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			$this->data->size = $size*0.8;

			// force la taille minimale à 5px
			if($this->data->size < 50){
				$this->data->size = 50;
			}

			$this->data->imgId = $id;
			$this->data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$this->data->content = "photoView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

		private function setMenu()
		{
			$this->data->menu['Home'] = "index.php";
			$this->data->menu['A propos'] = "index.php?controller=Home&action=aPropos";
			$this->data->menu['First'] = "index.php?controller=Photo&action=first";
			$this->data->menu['Random'] = "index.php?controller=Photo&action=random";
			$this->data->menu['More'] = "index.php?controller=PhotoMatrix&action=more&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg . "&size=" . $this->data->size;
			$this->data->menu['Zoom +'] = "index.php?controller=Photo&action=zoomIn&imgId=" . $this->data->imgId . "&size=" . $this->data->size;
			$this->data->menu['Zoom -'] = "index.php?controller=Photo&action=zoomOut&imgId=" . $this->data->imgId . "&size=" . $this->data->size;

			$this->data->liens['Prev'] = "index.php?controller=Photo&action=prev&imgId=" . $this->data->imgId . "&size=" . $this->data->size;
			$this->data->liens['Next'] = "index.php?controller=Photo&action=next&imgId=" . $this->data->imgId . "&size=" . $this->data->size;
		}
}
