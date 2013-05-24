<?php
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

?>
