<?php  
if($_SERVER['REQUEST_METHOD'] == "POST"){
    require "backendchallenge.php";
    $err= addList($list_name, $list_value);
}
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
        <p><?=$err?></p>
    </div>
    <div style="background: whitesmoke;" class="w3-container w3-center">
        <h1>Voeg een lijst toe!</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']). '?confirm=yes'?>" method="post"> 
            <input type="text" name="list_name" id="list_name" placeholder="Voer lijstnaam in">
            <br>
            <textarea name="list_value" id="list_value" cols="30" rows="10" placeholder="Lijst waarde"></textarea>
            <br>
            <button name="submit" type="submit" class="w3-green w3-round-xlarge w3-button">MAAK</button>
            <button type="submit" class="w3-blue w3-round-xlarge w3-button">PAK VOORBEELD</button>
        </form>
    </div>
</body>
</html>