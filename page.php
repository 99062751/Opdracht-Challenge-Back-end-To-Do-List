<?php  
require "backendchallenge.php";
$data= addList($list_name, $list_value);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>To Do List</title>
</head>
<body>
    <div class="w3-red w3-bar w3-center w3-padding">
        <p><?=$data?></p>
    </div>
    <h1>Voeg een lijst toe!</h1>
    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']). '?confirm=yes'?>" method="post"> 
        <input type="text" name="list_name" id="list_name" placeholder="Voer lijstnaam in">
        <br>
        <textarea name="list_value" id="list_value" cols="30" rows="10" placeholder="Lijst waarde"></textarea>
        <br>
        <button type="submit">MAAK</button>
        <button type="submit">PAK VOORBEELD</button>
    </form>
</body>
</html>