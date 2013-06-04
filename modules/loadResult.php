
<form class="form-horizontal" action="/" method="GET">
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
error_reporting(E_ALL);
ini_set('display_errors', True);

require('yummly.php');
require('simple_html_dom.php');
require('sort.php');
require('scraper.php');
require('databaselogin.php');

function userlikes($recipe,$user){
    $sql = "SELECT * FROM recipelist where userid=$user and searchid='$recipe' and favorited=1";
    $result = dbQuery($sql);
    if($result){
	return 1;
    }
    return 0;
}


function userdislikes($recipe,$user){
    $sql = "SELECT * FROM recipelist where userid=$user and searchid='$recipe' and disliked=1";
    $result = dbQuery($sql);
    if($result){
	return 1;
    }
    return 0;
}

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

    if($_GET['user']){
	$user = $_GET['user'];
    }
    else{
	$user = NULL;
    }
?>
    <input type="hidden" name="ingredients" value="<?php echo $ingredients;?>">
    <input type="hidden" name="diet" value= <?php echo $diet;?> >
    <input type="hidden" name="excludedIngredient" value= <?php echo $excluded;?> >
    <input type="hidden" name="cuisine" value= <?php echo $cuisine;?> >
    <input type="hidden" name="page" value="SearchResult">
    <input type="hidden" name="user" value="<?php echo $user;?>">
</form>

<?php
    $recipes = search($ingredients,$maxTotalTimeInSeconds, $cuisine,$excluded,$diet,$minServings, $maxServings);

    if($recipes){
            if ($maxTotalTimeInSeconds != $defaultTime){
                $recipes = sortRecipesByPrepTime($recipes);
            }

            //echo "<pre>"; var_dump($recipes); echo "</pre>";
            echo "<div class='bs-docs-grid'>";
	    $likes = '';
	    $all = '';
            foreach($recipes as $recipe){
		if($user){
		    if(userdislikes($recipe['id'],$user)){
			continue;
		    }
		}
		$html = '';
                $html .= "
                <div class='row show-grid'>
                <div class='span1'>
                ";	
                if($recipe['image']){
                $html .= "<img src='{$recipe['image']}' class='img-rounded' align='center'>";
                }
                $html .= "
                </div>
                <div class='span11'>
                    <h2><a href=\"http://www.yummly.com/recipe/{$recipe['id']}\">{$recipe['name']}</h2>
                    <p>See Recipe on Yummly</p></a>
                ";
		if ($user){
		    if(userlikes($recipe['id'],$user)){
			$html .= "You favourited this recipe.";
		    }
		    else{
			$html .= "<div id=\"{$recipe['id']}\"><img src=\"img/thumbs_up.png\" height=\"15\" width=\"15\"> <a href=\"javascript:like('{$recipe['id']}',$user)\">Favourite</a>";
			$html .= " or <img src=\"img/thumbs_down.png\" height=\"15\" width=\"15\"> <a href=\"javascript:dislike('{$recipe['id']}',$user)\">Dislike</a></div>";
		    }
		}
                if ($minServings || $maxServings){
		    $html .= " <p>Servings: " . $recipe['servingSize'] . " </p> "; 
                }
                if ($maxTotalTimeInSeconds != $defaultTime){
		    $html .= "<p>Total Time: " . $recipe['totalTimeInSeconds']/60 . " minutes</p>";
                }    
                $html .= "
                    <p>Ingredients:</p>
                    <ul>
                ";
                foreach($recipe['ingredients'] as $ingredient){
		    $html .= "<li>$ingredient</li>";
                }
                $html .= "
                    </ul>
                </div>
                </div>";
		if(userlikes($recipe['id'],$user)){
		    $likes .= $html;
		}
		else{
		    $all .= $html;
		}
            }
	    if($likes){
		echo "<h3>Favourites</h3>\n$likes\n<hr>\n";
		echo "<h3>More Recipes</h3>\n";
	    }
	    echo $all;
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
