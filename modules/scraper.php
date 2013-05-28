<?php
include 'simple_html_dom.php';

class Scrapper {

var $html;
var $id = NULL;

public function Scrapper($aid) {
    $this->id = $aid;
    $url = 'http://www.yummly.com/recipe/'.$aid;
    //$this->html = new simple_html_dom();
    $this->html = @file_get_html($url);
}
private function scrapeServingSize() {
    if($this->html !== FALSE){
	$str = $this->html;
	$yieldTag = $str->find('span[class=yield]');
    if ($yieldTag){
        $yieldString = $yieldTag[0]->plaintext;
	    return $yieldString;	
    }
    }
    return -1;
}
private function getTime(){
    //var_dump($this->html);
    //$ret = $this->html->find('div[class=definition]');
    if($this->html !== FALSE){
	foreach($this->html->find('div[class=definition]') as $div){
	    //echo $div.'<br>';
	    foreach($div->find('h5') as $ob){
		if(is_numeric(strpos($ob,'Total Time'))){
		    //echo $div->plaintext . '<br>';
		    return $div->plaintext;
		}
	    }
	}
    }
    return -1;
}

private function interpTime($str){
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

private function interpServings($str){
    $pieces = explode(" ",$str);
    for($i = 0; $i < count($pieces); $i++){
	    if(is_numeric($pieces[$i])){
            return $pieces[$i];
        }
    }
    return -2;
}

/*function testConversion($url,$actual){
    $timeStr = getTime($url);
    $time = interpTime($timeStr);
    //echo $time . "<br>" . $actual . "<hr>";
}*/

    
public function getPrepTime() {
    $query = 'SELECT time FROM preptimes WHERE yummly_id =' .$this->id;
    $result = dbQuery($query);
    if ($result) {
        return $result;
    } else {
        $url = 'http://www.yummly.com/recipe/'.$this->id;
        $time = $this->getTime();
        if(!is_numeric($time)){
                $timeInSeconds = $this->interpTime($time);
        }
        else{
                $timeInSeconds = -1;
        }
        $insertToDb = "INSERT INTO preptimes VALUES ('{$this->id}',$timeInSeconds)";
        //echo $insertToDb . "<br>";
        mysql_query($insertToDb);
        return $timeInSeconds;
    }
}

public function getServingSize(){
    $query = 'SELECT servingsize FROM servingsizes WHERE yummly_id =' .$this->id;
    $result = dbQuery($query);
    if ($result) {
        return $result;
    } else {
        $url = 'http://www.yummly.com/recipe/'.$this->id;
        $servingsize = $this->scrapeServingSize();
        if (!is_numeric($servingsize)){
            $servingsize = $this->interpServings($servingsize);
        }
        else{
            $servingsizse = -1;
        }
        $insertToDb = "INSERT INTO servingsizes VALUES ('{$this->id}',$servingsize)";
        //echo $insertToDb . "<br>";
        mysql_query($insertToDb);
        return $servingsize;
    }
}

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
