<?php
	require_once("model/imageDAO.php");
	require_once("model/data.php");

	class PhotoMatrix {

		protected $imageDAO;
		public $data;

		function __construct() {
      $this->imageDAO = new ImageDAO();
			$this->data = new Data();
		}


    // ACTIONS DU CONTROLEUR //
    // Action par défaut : affichage de 2 images à partir de l'image d'ID 1
    function index()
    {
			// Récupère l'imgID de data
			$id = $this->data->imgId;
			$nbImg = $this->data->nbImg;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nbImg);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage des n images suivantes
    function next()
    {
			if(isset($_GET['nbImg'])){
				$nb = $_GET['nbImg'];
			}else{
				$nb = 2;
			}

			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			// calcul du next
			if($id + $nb < $this->imageDAO->size()){
				$nextId = $this->imageDAO->jumpToImage($this->imageDAO->getImage($id), $nb);
			}else{
				$nextId = $nb - ($this->imageDAO->size() - $id);
			}


			$this->data->nbImg = $nb;
			$this->data->imgId = $nextId;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($nextId), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage des n images précédentes
    function prev()
    {
			if(isset($_GET['nbImg'])){
				$nb = $_GET['nbImg'];
			}else{
				$nb = 2;
			}

			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			// calcul du prev
			if($id && $id - $nb > 1){
				$prevId = $id - $nb;
			}else{
				$prevId = 1;
			}

			// calcul du nombre d'images avant 1 à afficher
			if(($id - $nb) < 1){
				$prevs = ($id - $nb) * (-1);
				$prevId = $this->imageDAO->size() - $prevs;
			}

			$this->data->nbImg = $nb;
			$this->data->imgId = $prevId;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($prevId), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affichage d'une matrice d'images à partir d'une image aléatoire
    function random()
    {
			if(isset($_GET['nbImg'])){
				$nb = $_GET['nbImg'];
			}else{
				$nb = 2;
			}

			// tire un ID au hasard
			$id = $this->imageDAO->getRandomImage();

			$this->data->imgId = $id;
			$this->data->nbImg = $nb;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affiche 2x plus d'images
    function more()
    {
			// calcul du nouveau nombre d'images à afficher
			if(isset($_GET['nbImg'])){
				$nb = $_GET['nbImg']*2;
			}else{
				$nb = 2;
			}

			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			$this->data->nbImg = $nb;
			$this->data->imgId = $id;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

    // Affiche 2x moins d'images
    function less()
    {
			// calcul du nouveau nombre d'images à afficher
			if(isset($_GET['nbImg']) && $_GET['nbImg']/2 > 1){
				$nb = $_GET['nbImg']/2;
			}else{
				$nb = 1;
			}

			if(isset($_GET['imgId'])){
				$id = $_GET['imgId'];
			}else{
				$id = 1;
			}

			$this->data->nbImg = $nb;
			$this->data->imgId = $id;

            if($nb == 1){
                header("Location: index.php?controller=Photo&action=index&imgId=" . $this->data->imgId);
                exit;
            }

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu();
			require_once("view/mainView.php");
    }

		private function setMenu()
		{
			$this->data->menu['Home'] = "index.php";
			$this->data->menu['A propos'] = "index.php?controller=Home&action=aPropos";
			$this->data->menu['First'] = "index.php?controller=Photo&action=first";
			$this->data->menu['Random'] = "index.php?controller=PhotoMatrix&action=random&nbImg=" . $this->data->nbImg;
			$this->data->menu['More'] = "index.php?controller=PhotoMatrix&action=more&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
			$this->data->menu['Less'] = "index.php?controller=PhotoMatrix&action=less&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;

			$this->data->liens['Prev'] = "index.php?controller=PhotoMatrix&action=prev&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
			$this->data->liens['Next'] = "index.php?controller=PhotoMatrix&action=next&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
		}
}
