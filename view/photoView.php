<?php # mise en place de la vue partielle : le contenu central de la page
  # Mise en place des deux boutons
  print "<p>\n";
  print "<a href=\"" . $this->data->liens['Prev'] . "\"><img class=\"arrows\" src=\"view/img/prev.png\" /></a> ";
  print "<span class=\"titre-photo\">" . $this->imageDAO->getImage($this->data->imgId)->getComment() . "</span>";
  print "<a href=\"" . $this->data->liens['Next'] . "\"><img class=\"arrows\" src=\"view/img/next.png\" /></a>\n";
  print "</p>\n";

  print "<p class=\"titre-cat\">" . $this->imageDAO->getImage($this->data->imgId)->getCategory() . "</p>";
  # Affiche l'image avec une reaction au click
  print "<a href=\"#\">\n";
  // Réalise l'affichage de l'image
  print "<img src=\"" . $this->data->imageURL . "\" width=\"" . $this->data->size . "px\" />\n";
  print "</a>\n";
  ?>
