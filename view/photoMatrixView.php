<?php # mise en place de la vue partielle : le contenu central de la page
  # Mise en place des deux boutons
  print "<p>\n";
  print "<a href=\"" . $this->data->liens['Prev'] . "\">Prev</a> ";
  // pre-calcul de la page d'images suivante
  print "<a href=\"" . $this->data->liens['Next'] . "\">Next</a> ";
  print "</p>\n";

  # Affiche de la matrice d'image avec une reaction au click
  print "<a href=\"#\">\n";
  // Réalise l'affichage de l'image

  # Adapte la taille des images au nombre d'images présentes
  $size = 480 / sqrt(count($this->data->imagesURLS));
  # Affiche les images
  foreach ($this->data->imagesURLS as $i) {
    print "<a href=\"index.php?controller=Photo&action=index&imgId=".$i->getId()."\"><img src=\"".$i->getPath()."\" height=\"".$size."\"></a>\n";
  };
  ?>
