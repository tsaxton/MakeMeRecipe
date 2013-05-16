<?php
<<<<<<< HEAD
if($_GET['ingredients']){
    $query = $_GET['ingredients'];
    $recipes = search($query);
    $sortedByPrep = sortRecipesByPrepTime($recipes);
    $recipes = $sortedByPrep;
    
    echo $recipes[0]['id'];

    foreach($recipes as $recipe){
	echo "<h2><a href=\"?page=recipe&id={$recipe['id']}\">{$recipe['name']}</a></h2>";
    
    echo "Prep time: ";
    echo $recipe['totalTimeInSeconds']/60 . " minutes. <br>";
	echo "Ingredients:\n<ul>";
    
	foreach($recipe['ingredients'] as $ingredient){
	    echo "<li>$ingredient</li>";
	}
    
	echo "</ul>";
=======
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

    foreach($recipes as $recipe){
		echo "<h2><a href=\"?page=recipe&id={$recipe['id']}\">{$recipe['name']}</a></h2>";
		echo "Ingredients:\n<ul>";
	foreach($recipe['ingredients'] as $ingredient){
	    echo "<li>$ingredient</li>";
	}
		echo "</ul>";
>>>>>>> ba08edc5ea98feb1a59cd805f08f872787806190
    }
} else{
    echo "You did not specify a query.";
}
