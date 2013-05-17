<div class="page-header"><h2>Search Results</h2></div>
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
		<p>Prep Time: " . $recipe['totalTimeInSeconds']/60 . " minutes</p>
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
    echo "You did not specify a query.";
}
?>
