<?php
	require_once("model/imageDAO.php");
	require_once("model/data.php");

	class PhotoMatrix {

		protected $imageDAO;

		function __construct() {
      $this->imageDAO = new ImageDAO();
		}


    // ACTIONS DU CONTROLEUR //
    // Action par défaut
    function index()
    {
			$data = new data();
			$data->imageURL = $this->imageDAO->getFirstImage()->getPath();
			$data->content = "photoMatrixView.php";
			$this->setMenu($data);
			require_once("view/mainView.php");
    }
    // // Affichage à partir de l'image 1
    // function first()
    // {
		//
    // }
		//
    // // Affichage des n images suivantes
    // function next()
    // {
		//
    // }
		//
    // // Affichage des n images précédentes
    // function prev()
    // {
		//
    // }
		//
    // // Affichage d'une matrice d'images à partir d'une image aléatoire
    // function random()
    // {
		//
    // }
		//
    // // Affiche 2x plus d'images
    // function more()
    // {
		// 	$data = new data();
		// 	$data->content = "photoMatrixView.php";
		// 	$this->setMenu($data);
		// 	require_once("view/mainView.php");
    // }

    // // Affiche 2x moins d'images
    // function less()
    // {
		//
    // }

		private function setMenu($data)
		{
			$nbImg = $_GET['nbImg'];
			if(!isset($nbImg)){
				$nbImg=2;
			}

			$id = $_GET['imgId'];
			if(isset($id) && $id+$nbImg < $this->imageDAO->size()){
				$nextId = $id + $nbImg;
			}else{
				$nextId = 1;
			}

			if(isset($id) && $id-$nbImg > 1){
				$prevId = $id - $nbImg;
			}else{
				$prevId = 1;
			}

			$size = 480;
			$data->imgId = $id;
			$data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nbImg);

			if($nbImg < 1){
				$nbImg = 1;
			}

			$data->menu['Home'] = "index.php";
			$data->menu['A propos'] = "index.php?controller=Home&action=aPropos";
			$data->menu['First'] = "index.php?controller=Photo&action=first&imgId=1";
			$data->menu['Random'] = "index.php?controller=PhotoMatrix&action=random&nbImg=" . $nbImg;
			$data->menu['More'] = "index.php?controller=PhotoMatrix&action=index&imgId=" . $id . "&nbImg=" . $nbImg*2;
			$data->menu['Less'] = "index.php?controller=PhotoMatrix&action=index&imgId=" . $id . "&nbImg=" . $nbImg/2;

			$data->liens['Prev'] = "index.php?controller=PhotoMatrix&action=index&imgId=" . $prevId . "&size=" . $size . "&nbImg=" . $nbImg;
			$data->liens['Next'] = "index.php?controller=PhotoMatrix&action=index&imgId=" . $nextId . "&size=" . $size . "&nbImg=" . $nbImg;
		}
}
