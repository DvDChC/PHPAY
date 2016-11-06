<?php # mise en place de la vue partielle : le contenu central de la page
  # Mise en place des deux boutons
  print "<form method=\"post\" action=\"index.php?controller=Category&action=index\">";
  print "<select name=\"category\" id=\"catgeory_select\" onchange=\"www.google.fr\"><option value=\"\" disabled selected>Filtrer par catégorie...</option>";
  print "<option value=\"-1\">-- Aucune --</option>";
  foreach($this->imageDAO->getCategories() as $category){
    print "<option value=\"" . $category . "\">" . $category . "</option>";
  }
  print "</select> <input type=\"submit\" value=\"Go!\"></form>";
  print "<p>\n";
  print "<a href=\"" . $this->data->liens['Prev'] . "\">Prev</a> ";

  print "<a href=\"" . $this->data->liens['Next'] . "\">Next</a>\n";
  print "</p>\n";

  print "<p>" . $this->imageDAO->getImage($this->data->imgId)->getCategory();
  print " : " . $this->imageDAO->getImage($this->data->imgId)->getComment() . "</p>";
  # Affiche l'image avec une reaction au click
  print "<a href=\"#\">\n";
  // Réalise l'affichage de l'image
  print "<img src=\"" . $this->data->imageURL . "\" width=\"" . $this->data->size . "px\" />\n";
  print "</a>\n";
  ?>
