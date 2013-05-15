<?php
if($_GET['id']){
    $id = $_GET['id'];
    $recipe = getRecipe($id);
    echo "<img src=\"{$recipe['image']}\" align=\"right\">";
    echo "<h2><a href=\"{$recipe['link']}\" target=\"_blank\">{$recipe['name']}</a></h2>";
    echo "Yields: {$recipe['servings']} Servings<br>";
    echo "Rating: {$recipe['rating']}/5<br>";
    echo "Powered by: <a href=\"{$recipe['yummly']}\" target=\"_blank\">Yummly</a>";
    echo "<h3>Ingredients</h3>\n<ul>";
    foreach($recipe['ingredients'] as $ingredient){
	echo "<li>$ingredient</li>";
    }
    echo "</ul>";
}
else{
    echo "No recipe specified.";
}
