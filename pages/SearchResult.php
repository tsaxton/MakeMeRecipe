<?php
if($_GET['ingredients']){
    $query = $_GET['ingredients'];
    $recipes = search($query);

    foreach($recipes as $recipe){
	echo "<h2><a href=\"?page=recipe&id={$recipe['id']}\">{$recipe['name']}</a></h2>";
	echo "Ingredients:\n<ul>";
	foreach($recipe['ingredients'] as $ingredient){
	    echo "<li>$ingredient</li>";
	}
	echo "</ul>";
    }
}
else{
    echo "You did not specify a query.";
}
