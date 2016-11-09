<?php
require_once("comment.php");
# Le 'Data Access Object' d'un ensemble images
class commentDAO
{
    function __construct()
    {
        $dsn = 'sqlite:model/data/image.db'; // Data source name
        $usr = '';
        $pwd = '';
        try {
            $this->db = new PDO($dsn, $usr, $pwd);
        } catch (PDOException $e) {
            die ("Erreur : " . $e->getMessage());
        }
    }

    # Retourne le nombre de commentaires pour une image donnée
    function size($imgId)
    {
        if($imgId){
            $res = $this->db->query("SELECT COUNT(*) FROM commentaire WHERE image_id = ?", $imgId);
            return $res->fetchColumn();
        }else{
            return null;
        }
    }

    # Retourne les commentaires pour une image donnée
    function getComments($imgId){
        $s = $this->db->query('SELECT * FROM commentaire WHERE image_id = ' . $imgId, 0);
        if ($s) {
            $s->setFetchMode(PDO::FETCH_CLASS, 'comment');
            $result = $s->fetchAll();
            return $result;
        } else {
            print "Error in getComments <br/>";
            $err= $this->db->errorInfo();
            print $err[2]."<br/>";
        }
    }

    # Sauvegarde le commentaire en base de données
    function addComment($imgId, $commentaire, $authorId){
        $commentaire = str_replace("'", "''", $commentaire);
        $commentaire = htmlentities($commentaire);
        $s = $this->db->prepare("INSERT INTO commentaire(image_id, comment, author_id) VALUES ('".$imgId."', '".$commentaire."', '".$authorId."')");
        $s->execute();
    }

    # Supprime un commentaire
    function deleteComment($id){
        $s = $this->db->prepare("DELETE FROM commentaire WHERE id =" .$id);
        if($s){
            $s->execute();
        }
    }
}