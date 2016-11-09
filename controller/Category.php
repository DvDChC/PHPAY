<?php
require_once("model/imageDAO.php");
require_once("model/data.php");

class Category
{

    protected $imageDAO;
    public $data;
    protected $category;

    function __construct()
    {
        $this->imageDAO = new ImageDAO();
        $this->data = new Data();
    }


    // ACTIONS DU CONTROLEUR //
    // Affiche les images d'une catégorie
    function index()
    {
        $cat = $this->getCategory();

        if ($cat == -1) {
            header("Location: index.php?controller=Photo&action=index");
            exit;
        }

        $images = $this->imageDAO->getImagesFromCategory($cat);
        $nb = count($images);

        if ($nb < 1)
            $nb = 1;

        $this->data->nbImg = $nb;
        $this->data->imagesURLS = $this->imageDAO->getImagesFromCategory($cat);
        $this->data->content = "photoMatrixView.php";
        $this->category = $cat;
        $this->setMenu();
        require_once("view/mainView.php");
    }

    // Affichage des images de la catégorie suivante
    function next()
    {
        $cat = $this->getCategory();
        $numCat = array_search($cat, $this->imageDAO->getCategories());

        // vérifie qu'on ne dépasse pas le nombre total de catégories ; revient au début si oui
        if ($numCat < count($this->imageDAO->getCategories()) - 1) {
            $cat = $this->imageDAO->getCategories()[$numCat + 1];
        } else {
            $cat = $this->imageDAO->getCategories()[0];
        }

        $images = $this->imageDAO->getImagesFromCategory($cat);
        $nb = count($images);

        if ($nb < 1)
            $nb = 1;

        $this->data->nbImg = $nb;
        $this->data->imagesURLS = $this->imageDAO->getImagesFromCategory($cat);
        $this->data->content = "photoMatrixView.php";
        $this->category = $cat;
        $this->setMenu();
        require_once("view/mainView.php");
    }

    // Affichage des n images précédentes
    function prev()
    {
        $cat = $this->getCategory();
        $numCat = array_search($cat, $this->imageDAO->getCategories());

        if ($numCat && $numCat >= 1) {
            $cat = $this->imageDAO->getCategories()[$numCat - 1];
        } else {
            $cat = $this->imageDAO->getCategories()[count($this->imageDAO->getCategories()) - 1];
        }

        $images = $this->imageDAO->getImagesFromCategory($cat);
        $nb = count($images);

        if ($nb < 1)
            $nb = 1;

        $this->data->nbImg = $nb;
        $this->data->imagesURLS = $this->imageDAO->getImagesFromCategory($cat);
        $this->data->content = "photoMatrixView.php";
        $this->category = $cat;
        $this->setMenu();
        require_once("view/mainView.php");
    }

    // Affichage d'une matrice d'images à partir d'une image aléatoire
    // function random()
    // {
    // 	if(isset($_GET['nbImg'])){
    // 		$nb = $_GET['nbImg'];
    // 	}else{
    // 		$nb = 2;
    // 	}
    //
    // 	// tire un ID au hasard
    // 	$id = $this->imageDAO->getRandomImage();
    //
    // 	$this->data->imgId = $id;
    // 	$this->data->nbImg = $nb;
    //
    // 	$this->data->imagesURLS = $this->imageDAO->getImageList($this->imageDAO->getImage($id), $nb);
    // 	$this->data->content = "photoMatrixView.php";
    // 	$this->setMenu();
    // 	require_once("view/mainView.php");
    // }

    private function setMenu()
    {
        $this->data->menu['Home'] = "index.php";
        $this->data->menu['A propos'] = "index.php?controller=Home&action=aPropos";
        $this->data->menu['First'] = "index.php?controller=Photo&action=first";
        // $this->data->menu['Random'] = "index.php?controller=Category&action=random&nbImg=" . $this->data->nbImg . "&category=" . $this->category;

        $this->data->liens['Prev'] = "index.php?controller=Category&action=prev&nbImg=" . $this->data->nbImg . "&category=" . urlencode($this->category);
        $this->data->liens['Next'] = "index.php?controller=Category&action=next&nbImg=" . $this->data->nbImg . "&category=" . urlencode($this->category);
    }

    private function getCategory()
    {
        if (isset($_GET['category']) && $_GET['category'] != "") {
            return $_GET['category'];
        } elseif (isset($_POST['category']) && $_POST['category'] != "") {
            return $_POST['category'];
        } else {
            header("Location: index.php?controller=Photo&action=index");
            exit;
        }
    }
}
