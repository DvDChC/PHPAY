<?php
	require_once("model/imageDAO.php");
	require_once("model/data.php");

	class PhotoMatrix {

		protected $imageDAO;
		public $data;

		function __construct() {
      $this->imageDAO = new ImageDAO();
			$this->data = new data();
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
			$this->setMenu($this->data);
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

			// calcul du next
			if(isset($_GET['imgId']) && $_GET['imgId']+$nb < $this->imageDAO->size()){
				$nextId = $this->imageDAO->jumpToImage($this->imageDAO->getImage($_GET['imgId']), $nb);
			}else{
				$nextId = 1;
			}

			$this->data->nbImg = $nb;
			$this->data->imgId = $nextId;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($nextId), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu($this->data);
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

			// calcul du prev
			if(isset($_GET['imgId']) && $_GET['imgId'] - $nb > 1){
				$prevId = $_GET['imgId'] - $nb;
			}else{
				$prevId = 1;
			}

			$this->data->nbImg = $nb;
			$this->data->imgId = $prevId;

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($prevId), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu($this->data);
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
			$this->setMenu($this->data);
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
			$this->setMenu($this->data);
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

			$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nb);
			$this->data->content = "photoMatrixView.php";
			$this->setMenu($this->data);
			require_once("view/mainView.php");
    }

		private function setMenu()
		{
			$this->data->menu['Home'] = "index.php";
			$this->data->menu['A propos'] = "index.php?controller=Home&action=aPropos";
			$this->data->menu['First'] = "index.php?controller=Photo&action=first&imgId=1";
			$this->data->menu['Random'] = "index.php?controller=PhotoMatrix&action=random&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
			$this->data->menu['More'] = "index.php?controller=PhotoMatrix&action=more&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
			$this->data->menu['Less'] = "index.php?controller=PhotoMatrix&action=less&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;

			$this->data->liens['Prev'] = "index.php?controller=PhotoMatrix&action=prev&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
			$this->data->liens['Next'] = "index.php?controller=PhotoMatrix&action=next&imgId=" . $this->data->imgId . "&nbImg=" . $this->data->nbImg;
		}
}
