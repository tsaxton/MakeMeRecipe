<?php
include 'scraper.php';

function search($query, $time, $cuisine,$excluded){
    $query = str_replace(' ','+',$query);
    $query = str_replace(',','+',$query);
    $base_url =  'http://api.yummly.com/v1/api/recipes?_app_id=6082fbf2&_app_key=f4346b48f9a52cac8385d1ba029074e7';
    $query_url = $base_url . '&q=' . $query;
    if($cuisine){ 
	$query_url .= '&allowedCuisine[]=cuisine^cuisine-'.$cuisine;
    }      
    if($excluded){
	$exclude = str_getcsv($excluded);
	foreach($exclude as $food){
	    $query_url .= '&excludedIngredient[]='.urlencode($food);
	}
    }
    $query_url .= '&maxResult=50&maxTotalTimeInSeconds=100000';
    $results = file_get_contents($query_url);
    $data = json_decode($results,1);

    $match = $data['matches'];

    if(count($match) >= 10){
	$size = 10;
    }
    else{
	$size = count($match);
    }

    for($i=0; $i < $size; $i++){
	$id = $match[$i]['id'];
	$scraper = new Scrapper($id);
	$recipe[$i]['name'] = $match[$i]['recipeName'];
	$recipe[$i]['id'] = $id;
	$recipe[$i]['ingredients'] = $match[$i]['ingredients'];
	$recipe[$i]['totalTimeInSeconds'] = $scraper->getPrepTime();
	//echo $recipe[$i]['totalTimeInSeconds'].'<br>';
	if(count($match[$i]['smallImageUrls']) > 0){
	    $recipe[$i]['image'] = $match[$i]['smallImageUrls'][0];
	}
	else{
	    $recipe[$i]['image'] = null;
	}
	unset($scraper);
    }

    for($i=0; $i < $size; $i++){
        if ($recipe[$i]['totalTimeInSeconds'] > $time || $recipe[$i]['totalTimeInSeconds'] == -1){
            unset($recipe[$i]);
        } 
    }
    $recipe = array_values($recipe);
    $size = count($recipe);

    if($size == 0){
	$recipe = null;
    }

    //echo "<pre>"; var_dump($recipe); echo "</pre>";

    return $recipe;
}

function getRecipe($id){
    $base_url =  'http://api.yummly.com/v1/api/recipe/' . $id . '?_app_id=6082fbf2&_app_key=f4346b48f9a52cac8385d1ba029074e7';
    $results = file_get_contents($base_url);
    $recipe = json_decode($results,1);
    $ret['name'] = $recipe['name'];
    $ret['ingredients'] = $recipe['ingredientLines'];
    $ret['link'] = $recipe['source']['sourceRecipeUrl'];
    $ret['yummly'] = $recipe['attribution']['url'];
    if(array_key_exists('hostedLargeUrl',$recipe['images'][0])){
	$ret['image'] = $recipe['images'][0]['hostedLargeUrl'];
    }
    else{
	$ret['image'] = NULL;
    }
    $ret['yield'] = $recipe['yield'];
    $ret['rating'] = $recipe['rating'];
    $ret['servings'] = $recipe['numberOfServings'];
    $ret['totalTimeInSeconds'] = $recipe['totalTimeInSeconds'];
 

    return $ret;
}


