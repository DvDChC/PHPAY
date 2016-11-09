<?php
  session_start();
  # Controleur frontal (front controler)

  # En fonction du controleur et de l'action en parametre lance le bon traitement
  # Recherche le nom du controleur
  if (isset($_GET["controller"])) {
	  $controller_to_run = $_GET["controller"];
  } else {
    # Si pas de controleur trouvée, choisit celui par defaut
    $controller_to_run = "Home";
  }
  # Recherche du nom de l'action pour ce controleur
  if (isset($_GET["action"])) {
    $action = $_GET["action"];
  } else {
    # Si pas d'action trouvée, definit une action par defaut
    $action = "index";
  }

  # Chargement du module de controleur correspondant à l'action

  # Construit le nom du fichier PHP du controleur de l'action
  $controller_file_name = "controller/".$controller_to_run.'.php';

  if (file_exists($controller_file_name)){
    # Le fichier est trouvé, il est chargé et définit une nouvelle classe
    require_once($controller_file_name);

    # Construit le nom de la classe controller à activer
    $controllerClassName = $controller_to_run;
    # Vérifie que cette classe existe
    if (class_exists($controllerClassName)) {
      # Cree l'objet controleur de cette action
      $controller = new $controllerClassName();
      # Vérifie que le code de l'action existe
      if (method_exists($controller,$action)) {
        # Réalise le traitement adéquat el lancant l'action de ce controleur
        $controller->$action();
      } else {
        # Erreur dans le code, la classe de l'action n'est pas trouvé
        die("<b>### Erreur : la methode '$action' du controleur '$controllerClassName' du fichier '$controller_file_name' n'existe pas</b>
            </br>Conseil : verifiez l'orthographe du nom de cette methode dans le fichier $controller_file_name.");
      }
    } else {
      # Erreur dans le code, la classe de l'action n'est pas trouvé
      die("<b>### Erreur : la classe du controleur '$controllerClassName' du fichier $controller_file_name n'existe pas</b>
          </br>Conseil : verifiez l'orthographe du nom de cette classe dans le fichier $controller_file_name.");
    }
  } else{
    # Erreur dans le code, le fichier de l'action n'est pas trouvé
    die("<b>### Erreur : le fichier $controller_file_name est absent</b>
        </br>Conseil : il faut creer ce fichier, verifier son nom ou verifier le lien du bouton
        en particulier la valeur de la variable 'controller' dans l'URL.");
  }

?>
