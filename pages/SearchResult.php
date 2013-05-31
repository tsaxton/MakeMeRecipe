<div class="page-header"><h2>Search Results</h2></div>
<form class="form-horizontal" action="" method="GET">
    <input type="hidden" name="page" value="SearchResult">
    <div class="control-group">
    <label class="control-label" for="inputTime">Total Time:</label>
    <div class="controls">
            <div class="input-append">
        <input class="span2" id="inputTime" name="maxTotalTimeInSeconds" type="text" placeholder="60">
        <span class="add-on">mins</span>
        </div>
        </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="servingSize">Serving size:</label>
    <div class="controls">
        <input type="text" id="minServings" name="minServings" placeholder="Minimum">
        <input type="text" id="maxServings" name="maxServings" placeholder="Maximum">
    </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn">Filter Results</button>
    </div>
    </div>
<?php

include_once('modules/scraper.php');

if($_GET){

    $defaultTime = 100000;
    if ($_GET['maxTotalTimeInSeconds']){
        if ($_GET['maxTotalTimeInSeconds'] == $defaultTime){
        $maxTotalTimeInSeconds=$defaultTime;
        }else{
        $maxTotalTimeInSeconds=$_GET['maxTotalTimeInSeconds'];
        $maxTotalTimeInSeconds=$maxTotalTimeInSeconds*60;
        }
    } else{
	$maxTotalTimeInSeconds=$defaultTime;
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

   if($_GET['diet']){
    $diet=$_GET['diet'];
    } else{
    	$diet=NULL;
    }

   if($_GET['minServings']){
    $minServings =$_GET['minServings'];
    } else{
    	$minServings =NULL;
    }
    
   if($_GET['maxServings']){
    $maxServings =$_GET['maxServings'];
    } else{
    	$maxServings =NULL;
    }
?>
    <input type="hidden" name="ingredients" value= <?php echo $ingredients;?> >
    <input type="hidden" name="diet" value= <?php echo $diet;?> >
    <input type="hidden" name="excludedIngredient" value= <?php echo $excluded;?> >
    <input type="hidden" name="cuisine" value= <?php echo $cuisine;?> >
    <input type="hidden" name="maxTotalTimeInSeconds" value= <?php echo $maxTotalTimeInSeconds;?> >
</form>

<?php
    $recipes = search($ingredients,$maxTotalTimeInSeconds, $cuisine,$excluded,$diet,$minServings, $maxServings);

    if($recipes){
            if ($maxTotalTimeInSeconds != $defaultTime){
                $recipes = sortRecipesByPrepTime($recipes);
            }

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
                ";
                if ($minServings || $maxServings){
                echo " <p>Servings: " . $recipe['servingSize'] . " </p> "; 
                }
                if ($maxTotalTimeInSeconds != $defaultTime){
                echo "<p>Total Time: " . $recipe['totalTimeInSeconds']/60 . " minutes</p>";
                }    
                echo"
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
