<?php
    require_once(dirname(__FILE__) . '/lib/FatSecretAPI.php');
    require_once(dirname(__FILE__) . '/lib/config.php');
    $consumerkey = '34406636bbeb4ffe8ebab1aa2d415488';
    $consumersecret = '934d7557c20849c4860384e2f20b9872';

	$API = new FatSecretAPI($consumerkey, $consumersecret);
	
    $token;
    $secret;

    /*If user does not exist yet, create it*/
    $username = 'eecs394orange';
    try{
        $API->ProfileCreate($username, $token, $secret);
        print '<div>Success</div>';
    }
    catch(Exception $ex){
        //print '<div>Error: ' . $ex->getCode() . ' - ' . $ex->getMessage() . '</div>';
    }
	$auth = array('user_id'=>$username, 'token'=>$token, 'secret'=>$secret);

    /*Retrieve session key*/
	$sessionKey;
    try{
        $API->ProfileRequestScriptSessionKey($auth, 
            null, null, null, false, $sessionKey);
		print '<div style="width:500px"><script src="' . API_URL . 'key=' . API_KEY . '&auto_load=true&fatsecret_session_key=' . $sessionKey . '"></script></div>';
	}
	catch(FatSecretException $ex){
		print '<div>Error: ' . $ex->getCode() . ' - ' . $ex->getMessage() . '</div>';
	}
?>


