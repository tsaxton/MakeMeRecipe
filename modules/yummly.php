<?php
//include 'scraper.php';

function search($query, $time, $cuisine,$excluded,$diet,$minServings, $maxServings){
    $query = str_replace(' ','+',$query);
    $query = str_replace(',','+',$query);
    $base_url =  'http://api.yummly.com/v1/api/recipes?_app_id=6082fbf2&_app_key=f4346b48f9a52cac8385d1ba029074e7';
    $query_url = $base_url . '&q=' . strtolower($query);
    if($cuisine){ 
	$query_url .= '&allowedCuisine[]=cuisine^cuisine-'.$cuisine;
    }      
    if($excluded){
	$exclude = str_getcsv($excluded);
	foreach($exclude as $food){
	    $query_url .= '&excludedIngredient[]='.urlencode(strtolower($food));
	}
    }
    if($diet){
	$query_url .= '&allowedDiet[]='.$diet;
    }
    $query_url .= '&maxResult=25&maxTotalTimeInSeconds=100000';
    $results = file_get_contents($query_url);
    $data = json_decode($results,1);

    $match = $data['matches'];

    $size = count($match);

    $recipe = array();
    for($i=0; $i < $size; $i++){
	$id = $match[$i]['id'];
    if ($time != 100000 || $minServings || $maxServings){
	$scraper = new scrapper($id);
    }
	$recipe[$i]['name'] = $match[$i]['recipeName'];
	$recipe[$i]['id'] = $id;
	$recipe[$i]['ingredients'] = $match[$i]['ingredients'];
	if(count($match[$i]['smallImageUrls']) > 0){
	    $recipe[$i]['image'] = $match[$i]['smallImageUrls'][0];
	}
	else{
	    $recipe[$i]['image'] = null;
	}
    if ($minServings || $maxServings){
	    $recipe[$i]['servingSize'] = $scraper->getservingsize();
    }else{
        $recipe[$i]['servingSize'] = NULL;
    }
    if ($time != 100000){
	    $recipe[$i]['totalTimeInSeconds'] = $scraper->getpreptime();
    }else{
        $recipe[$i]['totalTimeInSeconds'] = NULL;
    }
    if ($time != 100000 || $minServings || $maxServings){
	    unset($scraper);
    }
    }

    //Remove recipes that exceed queried time
    if ($time != 100000){
    for($i=0; $i < $size; $i++){
        if ($recipe[$i]['totalTimeInSeconds'] > $time || $recipe[$i]['totalTimeInSeconds'] == -1){
        unset($recipe[$i]);
        } 
    }
    }
    $size = count($recipe);
    if($size == 0){
	$recipe = null;
    }else{
	$recipe = array_values($recipe);
    }

    //Remove recipes that exceed serving size
    if ($minServings){
    for($i=0; $i < $size; $i++){
        if (($recipe[$i]['servingSize'] < $minServings) || ($recipe[$i]['servingSize'] == -1)){
        unset($recipe[$i]);
        } 
    }
    $size = count($recipe);
    if($size == 0){
	$recipe = null;
    }else{
	$recipe = array_values($recipe);
    }
    }
    if ($maxServings){
    for($i=0; $i < $size; $i++){
        if (($recipe[$i]['servingSize'] > $maxServings) || ($recipe[$i]['servingSize'] == -1)){
        unset($recipe[$i]);
        } 
    }
    $size = count($recipe);
    if($size == 0){
	$recipe = null;
    }else{
	$recipe = array_values($recipe);
    }
    }

    //echo "<pre>"; var_dump($recipe); echo "</pre>";

    return $recipe;
}



function basicSearch($query, $time, $cuisine,$excluded,$diet,$minServings, $maxServings){
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

    $size = count($match);

    $recipe = array();
    for($i=0; $i < $size; $i++){
	$id = $match[$i]['id'];
	//$scraper = new Scrapper($id);
	$recipe[$i]['name'] = $match[$i]['recipeName'];
	$recipe[$i]['id'] = $id;
	$recipe[$i]['ingredients'] = $match[$i]['ingredients'];
	//$recipe[$i]['totalTimeInSeconds'] = $scraper->getPrepTime();
	//$recipe[$i]['servingSize'] = $scraper->getServingSize();
	$recipe[$i]['totalTimeInSeconds'] = NULL;
	$recipe[$i]['servingSize'] = NULL;
	//echo $recipe[$i]['totalTimeInSeconds'].'<br>';
	if(count($match[$i]['smallImageUrls']) > 0){
	    $recipe[$i]['image'] = $match[$i]['smallImageUrls'][0];
	}
	else{
	    $recipe[$i]['image'] = null;
	}
	//unset($scraper);
    }
    if($size == 0){
	$recipe = null;
    }
    else{
	$recipe = array_values($recipe);
    }

    //echo "<pre>"; var_dump($recipe); echo "</pre>";

    return $recipe;
}
//if sortByPrepTime filter is set
//showTimes($recipe)
//showTimes{
//  

function getMoreInfo($recipes){
    $size = count($recipes);
    for($i=0; $i < $size; $i++){
        $scraper = new Scrapper($recipe[$i]['id']);
        $recipe[$i]['totalTimeInSeconds'] = $scraper->getPrepTime();
        $recipe[$i]['servingSize'] = $scraper->getServingSize();
        unset($scraper);
    }
    return $recipe;
}


