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
    if($_GET['cuisine']){
	$cuisine = $_GET['cuisine'];
    } else{
	$cuisine=NULL;
    }

    $recipes = search($ingredients,$maxTotalTimeInSeconds, $cuisine);
    $sortedByPrep = sortRecipesByPrepTime($recipes);
    $recipes = $sortedByPrep;

    foreach($recipes as $recipe){
	if($recipe['image']){
	echo "<img src=\"{$recipe['image']}\" class=\"img-rounded\" align=\"left\">";
	}
	echo "<a href=\"http://www.yummly.com/recipe/{$recipe['id']}\"><h2>{$recipe['name']}</h2>\n<p>See Recipe on Yummly</p></a>";
	echo "<p>Prep Time: " . $recipe['totalTimeInSeconds']/60 . " minutes<br>";
	echo "Ingredients:\n<ul>";
	foreach($recipe['ingredients'] as $ingredient){
	    echo "<li>$ingredient</li>";
	}
	echo "</ul></p>";
    }
}
else{
    echo "You did not specify a query.";
}
?>
