<?php
	require_once("image.php");
	# Le 'Data Access Object' d'un ensemble images
	class ImageDAO {

		# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		# A MODIFIER EN FONCTION DE VOTRE INSTALLATION
		# !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		# Chemin LOCAL où se trouvent les images
		private $path="model/IMG";
		# Chemin URL où se trouvent les images
		const urlPath="http://localhost/image/model/IMG";

		# Tableau pour stocker tous les chemins des images
		private $imgEntry;



		function __construct() {
				$dsn = 'sqlite:model/data/image.db'; // Data source name
				$usr = '';
				$pwd = '';
				try {
					$this->db = new PDO($dsn, $usr, $pwd); //$db est un attribut privé d'ImageDAO
				} catch (PDOException $e) {
					die ("Erreur : ".$e->getMessage());
				}
		}

		# Retourne le nombre d'images référencées dans le DAO
		function size() {
			$res = $this->db->query("SELECT COUNT(*) FROM image");
			return $res->fetchColumn();
		}

		# Retourne un objet image correspondant à l'identifiant
		function getImage($id) {
			$s = $this->db->query('SELECT * FROM image WHERE id='.$id);
			if ($s) {
				$s->setFetchMode(PDO::FETCH_CLASS,'image');
				$result = $s->fetch();
				// var_dump($result);
				if($result){
					return $result;
				}else{
					return $this->getImage(1);
				}
      } else {
        print "Error in getImage id=".$id."<br/>";
        $err= $this->db->errorInfo();
        print $err[2]."<br/>";
      }
		}


		# Retourne une image au hazard
		function getRandomImage() {
			return rand(1, $this->size());
		}

		# Retourne l'objet de la premiere image
		function getFirstImage() {
			return $this->getImage(1);
		}

		# Retourne l'image suivante d'une image
		function getNextImage(image $img) {
			$id = $img->getId();
			if ($id < $this->size()) {
				$img = $this->getImage($id+1);
			}
			return $img;
		}

		# Retourne l'image précédente d'une image
		function getPrevImage(image $img) {
			$id = $img->getId();
			if($id <= $this->size() && $id != 1){
				$img = $this->getImage($id-1);
			}else{
				$img = $this->getImage(1);
			}
			return $img;
		}

		# saute en avant ou en arrière de $nb images
		# Retourne l'id de la nouvelle image
		function jumpToImage(image $img, $nb) {
			if($nb < 1 && $nb > 0){
				$nb = 1;
			}
			$id = $img->getId();
			if ($id + $nb < $this->size() && $id + $nb > 0) {
				$img = $this->getImage($id + $nb);
			}else if($id + $nb >= $this->size()){
				$diff = $this->size() - $nb;
				$img = $this->getImage($diff+1);
			}else{
				$img = $this->getImage(1);
			}
			return $img->getId();
		}

		# Retourne la liste des images consécutives à partir d'une image
		function getImageList(image $img,$nb) {
			# Verifie que le nombre d'image est non nul
			if (!$nb > 0) {
				debug_print_backtrace();
				trigger_error("Erreur dans ImageDAO.getImageList: nombre d'images nul");
			}
			$id = $img->getId();
			$max = $id+$nb;
			while ($id <= $this->size() && $id < $max) {
				$res[] = $this->getImage($id);
				$id++;
			}

			$debut = 1;
			$fin = $this->size();

			// si le tableau de résultat n'a pas autant d'images (début ou fin de la liste),
			// on ajoute les premières ou dernières images en plus

			while(count($res) < $nb){
				if(($id + $nb) > $this->size()) {
					$res[] = $this->getImage($debut);
					$debut++;
				}elseif($id < 1){
					$res[] = $this->getImage($fin);
					$fin--;
				}
			}

			return $res;
		}

	// Retourne une liste des catégories d'images
	function getCategories(){
		$s = $this->db->query('SELECT DISTINCT category FROM image ORDER BY category ASC');
		if ($s) {
			$result = $s->fetchAll(PDO::FETCH_COLUMN, 0);
			if($result){
				return $result;
			}else{
				return $this->getImage(1);
			}
		} else {
			print "Error in getCategories<br/>";
			$err = $this->db->errorInfo();
			print $err[2]."<br/>";
		}
	}

	// Retourne la liste des images d'une catégorie
	function getImagesFromCategory($category){
		$s = $this->db->query('SELECT * FROM image WHERE category = \'' . $category . '\' ORDER BY id ASC');
		if ($s) {
			$s->setFetchMode(PDO::FETCH_CLASS,'image');
			$result = $s->fetchAll();
			if($result){
				return $result;
			}else{
				return $this->getImage(1);
			}
		} else {
			print "Error in getCategories<br/>";
			$err = $this->db->errorInfo();
			print $err[2]."<br/>";
		}
	}
}

	# Test unitaire
	# Appeler le code PHP depuis le navigateur avec la variable test
	# Exemple : http://localhost/image/model/imageDAO.php?test
	if (isset($_GET["test"])) {
		echo "<H1>Test de la classe ImageDAO</H1>";
		$imgDAO = new ImageDAO();
		echo "<p>Creation de l'objet ImageDAO.</p>\n";
		echo "<p>La base contient ".$imgDAO->size()." images.</p>\n";
		$img = $imgDAO->getFirstImage("");
		echo "La premiere image est : ".$img->getPath()."</p>\n";
		# Affiche l'image
		echo "<img src=\"".$img->getPath()."\"/>\n";
	}


	?>
