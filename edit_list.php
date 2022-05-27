<?php  
require "backendchallenge.php";
$id_list= $_GET["id"];
$listdata= getOneList($id_list);

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $condition= controle();
    if ($condition == true) {
        $output= updateList($_POST["list_newname"], $_POST["list_newvalue"], $id_list);
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
        <h1>Edit your list!</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF']). '?id='.$id_list .'&confirm=yes'?>" method="post"> 
            <input type="text" name="list_newname" id="list_newname" placeholder="Voer lijstnaam in" value="<?=$listdata['listname']?>">
            <br>
            <textarea name="list_newvalue" id="list_newvalue" cols="30" rows="10" placeholder="Lijst waarde"><?=$listdata['listvalue']?></textarea>
            <br>
            <button name="submit" type="submit" class="w3-green w3-round-xlarge w3-button">EDIT</button>
        </form>
    </div>

<?php require "templates/footer.php" ?>
