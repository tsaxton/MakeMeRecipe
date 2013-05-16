<?php
function search($query, $time, $cuisine){
    $query = str_replace(' ','+',$query);
    $query = str_replace(',','+',$query);
    $base_url =  'http://api.yummly.com/v1/api/recipes?_app_id=6082fbf2&_app_key=f4346b48f9a52cac8385d1ba029074e7';
    $query_url = $base_url . '&q=' . $query . '&maxTotalTimeInSeconds='.$time;
    if($cuisine){ 
    $query_url .= '&allowedCuisine[]=cuisine^cuisine-'.$cuisine;
    }      
    $results = file_get_contents($query_url);
    $data = json_decode($results,1);

    $match = $data['matches'];

    for($i=0; $i < 10; $i++){
	$recipe[$i]['name'] = $match[$i]['recipeName'];
	$recipe[$i]['id'] = $match[$i]['id'];
	$recipe[$i]['ingredients'] = $match[$i]['ingredients'];
	$recipe[$i]['totalTimeInSeconds'] = $match[$i]['totalTimeInSeconds'];
    }

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

function sortRecipesByParam($recipes, $sortparam){
    $sortdict = array();
    foreach ($recipes as $index => $recipe){
        $sortdict[$index] = $recipe[$sortparam];
    }
    array_multisort($sortdict, SORT_ASC, $recipes);
    return $recipes;

}

function sortRecipesByPrepTime($recipes){
   return sortRecipesByParam($recipes, 'totalTimeInSeconds');
}


