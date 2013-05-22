<?php
include 'simple_html_dom.php';

function getTime($url){
    $html = file_get_html($url);
    foreach($html->find('div[class=definition]') as $div){
	//echo $div;
	foreach($div->find('h5') as $ob){
	    if(is_numeric(strpos($ob,'Total Time'))){
		return $div->plaintext;
	    }
	}
    }
    return -1;
}

function interpTime($str){
    $pieces = explode(" ",$str);
    $time = 0;
    //var_dump($pieces);
    for($i = 0; $i < count($pieces); $i++){
	if(is_numeric($pieces[$i])){
	    if(is_numeric(strpos($pieces[$i+1],'hr'))){
		$time += $pieces[$i]*3600;
	    }
	    if(is_numeric(strpos($pieces[$i+1],'min'))){
		$time += $pieces[$i]*60;
	    }
	}
    }
    return $time;
}

function testConversion($url,$actual){
    $timeStr = getTime($url);
    $time = interpTime($timeStr);
    //echo $time . "<br>" . $actual . "<hr>";
}

// Tests
/*testConversion('http://www.yummly.com/recipe/Thai-coconut-chicken-noodle-soup-350876','3600');
testConversion('http://www.yummly.com/recipe/Tex-mex-chicken-and-rice-soup-351658','3900');
testConversion('http://www.yummly.com/recipe/Chinese-Chicken-Fried-Rice-Ii-Allrecipes','900');
testConversion('http://www.yummly.com/recipe/Mexi_chicken-Rice-Food-Network','1320');
testConversion('http://www.yummly.com/recipe/Chinese-chicken-salad-351139','2100');
testConversion('http://www.yummly.com/recipe/Lemon-Chicken-Rice-Soup-Recipezaar','2400');
testConversion('http://www.yummly.com/recipe/Saffron-Rice-The-Shiksa-Blog-46555','2700');
testConversion('http://www.yummly.com/recipe/Chicken-Wild-Rice-Soup-TasteOfHome','3000');
testConversion('http://www.yummly.com/recipe/One_Pot-Chicken-and-Brown-Rice-Martha-Stewart','3900');
testConversion('http://www.yummly.com/recipe/Salsa-Chicken-Rice-Casserole-Allrecipes','4800');*/


?>
