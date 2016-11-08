<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="fr" >
	<head>
		<title>Site SIL3</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" title="Normal" />
		</head>
	<body>
		<div id="menu">
			<h3>Menu</h3>
			<ul>
				<?php if(isset($_GET['controller']) && $_GET['controller']!='Home' && $_GET['controller']!='home'): ?>
					<form id="form_cat" method="post" action="index.php?controller=Category&action=index">
						<select name="category" id="catgeory_select">
							<option value="" disabled selected>Filtrer la catégorie</option>
							<option value="-1">-- Aucune --</option>
					<?php
						foreach($this->imageDAO->getCategories() as $category){
							print "<option value=\"" . $category . "\">" . $category . "</option>";
						}
					?>
						</select>
						<input type="submit" value="Go!">
					</form>
				<?php endif; ?>

				<?php
				# Mise en place du menu par un parcours de la table associative
					foreach($this->data->menu as $key => $item) {
            echo "<a href=\"" . $item . "\" >" . $key . "</a><br />";
          }
				?>
				</ul>
		</div>

		<div id="corps">
			<?php
        include($this->data->content);
      ?>
		<div id="pied_de_page">
			</div>
		</body>
	</html>
