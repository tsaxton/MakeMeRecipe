<div class="page-header"><h2>Search Results</h2></div>
<?php

include_once('modules/scraper.php');

if($_GET){
    if ($_GET['maxTotalTimeInSeconds']){
	$maxTotalTimeInSeconds=$_GET['maxTotalTimeInSeconds'];
	$maxTotalTimeInSeconds=$maxTotalTimeInSeconds*60;
    } else{
	$maxTotalTimeInSeconds=100000;
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
    if($_GET['excludedIngredient']){
    $excluded=$_GET['excludedIngredient'];
    } else{
    	$excluded=NULL;
    }

    $recipes = search($ingredients,$maxTotalTimeInSeconds, $cuisine,$excluded);
    if($recipes){
	$recipes = sortRecipesByPrepTime($recipes);

	//echo "<pre>"; var_dump($recipes); echo "</pre>";
	echo "<div class='bs-docs-grid'>";
	foreach($recipes as $recipe){
	    echo "
	    <div class='row show-grid'>
		<div class='span1'>
	    ";	
	    if($recipe['image']){
	    echo "<img src='{$recipe['image']}' class='img-rounded' align='center'>";
	    }
	    echo "
		</div>
		<div class='span11'>
		    <h2><a href=\"http://www.yummly.com/recipe/{$recipe['id']}\">{$recipe['name']}</h2>
		    <p>See Recipe on Yummly</p></a>
		    <p>Total Time: " . $recipe['totalTimeInSeconds']/60 . " minutes</p>
		    <p>Servings: I really have no idea </p> 
		    <p>Ingredients:</p>
		    <ul>
	    ";
	    foreach($recipe['ingredients'] as $ingredient){
		echo "<li>$ingredient</li>";
	    }
	    echo "
		    </ul>
		</div>
	    </div>";
	}
	echo "</div>";
    }
    else{
	echo "<p>Sorry, your recipe search did not return any results.</p>";
    }
}
else{
    echo "You did not specify a query.";
}
?>
