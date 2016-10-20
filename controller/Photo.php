<?php
	require_once("model/imageDAO.php");
  require_once("model/data.php");

	class Photo {

		protected $imageDAO;

		function __construct() {
      $this->imageDAO = new ImageDAO();
		}


    // ACTIONS DU CONTROLEUR //
    // Action par défaut
    function index()
    {
      $this->first();
    }

    // Affichage de la photo n°1.
    function first()
    {
			$data = new Data();
			$data->imageURL = $this->imageDAO->getFirstImage()->getPath();
			$data->content = "photoView.php";
			$data->imgId = 1;
			$this->setMenu($data);
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
			$data = new Data();
			$data->imageURL = $this->imageDAO->getImage($id)->getPath();
			$data->imgId = $this->calculeNext($id);
			$data->content = "photoView.php";
			$this->setMenu($data);
			require_once("view/mainView.php");
    }

    // Affichage de l'image précédente
    function prev()
    {

    }

    // Affichage d'une image aléatoire
    function random()
    {

    }

    // Zoom sur l'image
    function zoomIn()
    {

    }

    // Dézoom de l'image
    function zoomOut()
    {

    }

		private function setMenu($data)
		{
			$id = $_GET['imgId'];
			if(isset($id) && $id < $this->imageDAO->size()){
				$nextId = $id + 1;
			}else{
				$nextId = 1;
			}

			if(isset($id) && $id > 1){
				$prevId = $id - 1;
			}else{
				$prevId = 1;
			}

			$size=480;
			$nbImg=1;

			$data->menu['Home'] = "index.php";
			$data->menu['A propos'] = "index.php?controller=Home&action=aPropos";
			$data->menu['First'] = "index.php?controller=Photo&action=first&imgId=1";
			$data->menu['Random'] = "index.php?controller=Photo&action=random";
			$data->menu['More'] = "index.php?controller=PhotoMatrix&action=index&imgId=" . $id . "&nbImg=" . $nbImg*2;
			$data->menu['Zoom +'] = "index.php?controller=Photo&action=zoomIn";
			$data->menu['Zoom -'] = "index.php?controller=Photo&action=zoomOut";

			$data->liens['Prev'] = "index.php?controller=Photo&action=next&imgId=" . $prevId . "&size=" . $size;
			$data->liens['Next'] = "index.php?controller=Photo&action=next&imgId=" . $nextId . "&size=" . $size;
		}
		private function calculeNext($id)
		{
			if($id <= $this->imageDAO->size()){
				return $id++;
			}else{
				return 1;
			}
		}
}
