<!doctype html>
<html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', True);
include_once('modules/databaselogin.php');

/*include_once('modules/yummly.php');
include_once('modules/sort.php');
include_once('modules/scraper.php');*/

if(array_key_exists('page',$_GET)){
    $page = $_GET['page'];
}
else{
    $page = 'search';
}
if(array_key_exists('user',$_GET)){
    $user = $_GET['user'];
}
else{
    $user = '';
}
?>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakeMeRecipe</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="all">
    <link rel="stylesheet"  href="css/main.css" media="all">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<header>
    <h1>MakeMeRecipe</h1>
</header>

<style>
body {
    margin-left: 10px;
}
</style>
<?php
include "pages/$page.php";
?>
</body>
</html>
