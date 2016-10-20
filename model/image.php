<?php

  # Notion d'image
  class Image {
    private $path="";
    private $id=0;
    private $category="";
    private $comment="";

    function __construct(){
      $this->path = 'model/IMG/' . $this->path;
    }

    // function __construct($u,$id,$auth,$titre) {
    //   $this->url = $u;
    //   $this->id = $id;
    //   $this->author = $auth;
    //   $this->titre = $titre;
    // }

    # Retourne l'URL de cette image
    function getPath() {
		return $this->path;
    }

    function getComment() {
		return $this->comment;
    }

    function getCategory() {
		return $this->category;
    }

    function getId() {
      return $this->id;
    }
  }


?>
