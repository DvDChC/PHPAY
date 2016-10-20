<?php # mise en place de la vue partielle : le contenu central de la page
  # Mise en place des deux boutons
  print "<p>\n";
  print "<a href=\"" . $this->data->liens['Prev'] . "\">Prev</a> ";

  print "<a href=\"" . $this->data->liens['Next'] . "\">Next</a>\n";
  print "</p>\n";

  # Affiche l'image avec une reaction au click
  print "<a href=\"#\">\n";
  // Réalise l'affichage de l'image
  print "<img src=\"$this->data->imageURL\" />\n";
  print "</a>\n";
  ?>
