<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
    <title>Ma galerie d'images</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" title="Normal"/>
    <link rel="icon" type="image/png" href="img/pictures.png"/>
</head>
<body>
<div id="id01" class="modal">
    <form class="modal-content animate" method="POST" action="index.php?controller=Login">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close"
                  title="Close">&times;</span>
        </div>
        <div class="container">
            <label><b>Username</b></label>
            <input type="text" placeholder="Username" name="uname" required>

            <label><b>Password</b></label>
            <input type="password" placeholder="Password" name="pwd" required>

            <button name="login" type="submit">Login</button>

            <button name="signin" type="submit"> Sign in</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">
                Annuler
            </button>
        </div>
    </form>
</div>
<div id="menu">
    <h3>Menu</h3>
    <ul>
        <?php if (isset($_GET['controller']) && ($_GET['controller'] == 'Photo' || $_GET['controller'] == 'PhotoMatrix' || $_GET['controller'] == 'Category')): ?>
            <form id="form_cat" method="post" action="index.php?controller=Category&action=index">
                <select name="category" id="catgeory_select">
                    <option value="" disabled selected>Filtrer la catégorie</option>
                    <option value="-1">-- Aucune --</option>
                    <?php
                    foreach ($this->imageDAO->getCategories() as $category) {
                        print "<option value=\"" . $category . "\">" . $category . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Go!">
            </form>
        <?php endif; ?>

        <?php
        # Mise en place du menu par un parcours de la table associative
        foreach ($this->data->menu as $key => $item) {
            echo "<a href=\"" . $item . "\" >" . $key . "</a><br />";
        }
        ?>
    </ul>
    <?php
    if (isset($_SESSION['login'])) {
        print($_SESSION['login']);
        // Affiche un lien pour se déconnecter
        print("<a href='index.php?controller=Logout'> LOGOUT </a>");
    }else{
        # LOGIN
        print "<button onclick=\"document.getElementById('id01').style.display='block'\" style=\"width:auto;\">Login</button>";
    }
    ?>

</div>

<div id="corps">
    <?php
    include($this->data->content);
    ?>
    <div id="pied_de_page">
    </div>
</body>
</html>
