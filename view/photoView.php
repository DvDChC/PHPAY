<?php # mise en place de la vue partielle : le contenu central de la page
# Mise en place des deux boutons
print "<p>\n";
print "<a href=\"" . $this->data->liens['Prev'] . "\"><img class=\"arrows\" src=\"view/img/prev.png\" /></a> ";
print "<span class=\"titre-photo\">" . $this->imageDAO->getImage($this->data->imgId)->getComment() . "</span>";
print "<a href=\"" . $this->data->liens['Next'] . "\"><img class=\"arrows\" src=\"view/img/next.png\" /></a>\n";
print "</p>\n";

$cat = $this->imageDAO->getImage($this->data->imgId)->getCategory();
print "<a href=\"index.php?controller=Category&action=index&category=".$cat."\"><p class=\"titre-cat\">" . $cat . "</p>";
# Affiche l'image avec une reaction au click
print "<a href=\"#\">\n";
// Réalise l'affichage de l'image
print "<img src=\"" . $this->data->imageURL . "\" width=\"" . $this->data->size . "px\" />\n";
print "</a>\n";
print "<div class='commentaires' style='width:" . $this->data->size . "px;'>";
foreach ($this->data->commentaires as $com) {
    print "<div class=\"com\"><h2>" . $com->getAuthor() . " :</h2><br />" . $com->getComment() . "</div>";
}
if(isset($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = 1;
}
print "<div id=\"ajout-com\"><form id=\"form_com\" method=\"post\" action=\"index.php?controller=Photo&action=addComment&imgId=".$this->data->imgId."&author=". $id ."\">
                <label for='comment'>Ajoutez votre commentaire...</label><br />
                <textarea name='comment' required style='width: 100%;'></textarea>
                <br /><input type=\"submit\" style='float:right;' value=\"Commenter\">
            </form>";
print "</div>";
print "</div>";
?>
