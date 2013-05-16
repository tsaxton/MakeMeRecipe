<?php
error_reporting(E_ALL);
ini_set('display_errors', True);

include('modules/yummly.php');

if(array_key_exists('page',$_GET)){
    $page = $_GET['page'];
}
else{
    $page = 'search';
}
?>
<html>
<head>
    <title>MakeMeRecipe</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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
