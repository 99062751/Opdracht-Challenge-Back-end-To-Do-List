<?php  
if($_SERVER['REQUEST_METHOD'] == "POST"){
    require "backendchallenge.php";
    $condition= controle();
    if ($condition == true) {
        $output= addList($_POST["list_name"], $_POST["list_value"]);
    }else{
        $err= "Inputs are not filled out"; 
    }   
    
}

require "templates/header.php";
?>
    <?php if(isset($err)){?>
    <div class="w3-red w3-bar w3-center w3-padding">
        <p><?=$err?></p>
    </div>
    <?php }elseif(isset($output)){?>
        <div class="<?php $output[0] == true ? print('w3-green') : print('w3-red') ?> w3-bar w3-center w3-padding">
        <p><?=$output[1]?></p>
    </div>
    <?php }?>
    <div style="background: whitesmoke;" class="w3-container w3-center">
        <h1>Add a new list!</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']). '?confirm=yes'?>" method="post"> 
            <input type="text" name="list_name" id="list_name" placeholder="Voer lijstnaam in">
            <br>
            <textarea name="list_value" id="list_value" cols="30" rows="10" placeholder="Lijst waarde"></textarea>
            <br>
            <button name="submit" type="submit" class="w3-green w3-round-xlarge w3-button">ADD</button>
        </form>
    </div>

    <?php require "templates/footer.php" ?>
    