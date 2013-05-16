<?php
if($_GET){
    if ($_GET['maxTotalTimeInSeconds']){
	$maxTotalTimeInSeconds=$_GET['maxTotalTimeInSeconds'];
	$maxTotalTimeInSeconds=$maxTotalTimeInSeconds*60;
    } else{
	$maxTotalTimeInSeconds=3600;
    }
    if($_GET['ingredients']){
    	$ingredients= $_GET['ingredients'];
    } else{
    	$ingredients='';	
    }

    $recipes = search($ingredients,$maxTotalTimeInSeconds);
    $sortedByPrep = sortRecipesByPrepTime($recipes);
    $recipes = $sortedByPrep;

    foreach($recipes as $recipe){
	echo "<h2><a href=\"?page=recipe&id={$recipe['id']}\">{$recipe['name']}</a></h2>";
	echo "Ingredients:\n<ul>";
	foreach($recipe['ingredients'] as $ingredient){
	    echo "<li>$ingredient</li>";
	}
	echo "</ul>";
    }
 else{
    echo "You did not specify a query.";
}
?>
