<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

require('yummly.php');
require('simple_html_dom.php');
require('sort.php');
require('scraper.php');
if($_GET){
    if ($_GET['maxTotalTimeInSeconds']){
	$maxTotalTimeInSeconds=$_GET['maxTotalTimeInSeconds'];
	$maxTotalTimeInSeconds=$maxTotalTimeInSeconds*60;
    $inputtedTime = true;
    } else{
	$maxTotalTimeInSeconds=100000;
    $inputtedTime = false;
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

    if(($maxServings != NULL) || ($minServings != NULL) || ($inputtedTime == true)){
        echo "maxServings: " . $maxServings . "\n minServings: " . $minServings . "\n Time: " . $maxTotalTimeInSeconds;
        $simpleSearch = false;
        $recipes = search($ingredients,$maxTotalTimeInSeconds, $cuisine,$excluded,$diet,$minServings, $maxServings);
    }else{
        $simpleSearch = true;
        $recipes = basicSearch($ingredients,$maxTotalTimeInSeconds, $cuisine,$excluded,$diet,$minServings, $maxServings);
    }

//display recipes
    if($recipes){
            if ($simpleSearch == false){
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
                if ($simpleSearch == false){
                    echo "
                        <p>Total Time: " . $recipe['totalTimeInSeconds']/60 . " minutes</p>
                        <p>Servings: " . $recipe['servingSize'] . " </p> 
                        ";
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


