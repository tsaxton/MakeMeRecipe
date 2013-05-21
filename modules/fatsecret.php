<?php
include('modules/getSessionKey.php');

$api_key = '34406636bbeb4ffe8ebab1aa2d415488';
$baseurl = FatSecretAPI::$base . 'key=' . $api_key
        .'&auto_load=true&fatsecret_session_key=' . $sessionKey;


?>
