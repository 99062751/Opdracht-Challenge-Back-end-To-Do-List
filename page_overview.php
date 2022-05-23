<?php  
require "backendchallenge.php";
$listdata= getLists();
require "templates/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["task_submit"])){
        echo $_POST["task_card"], $_POST["id_list"], $_POST["task_duration"], $_POST["status_select"];
        addTask($_POST["task_card"], $_POST["id_list"], $_POST["task_duration"], $_POST["status_select"]);
    }elseif(isset($_POST["edit_submit"])){
        updateTask($_POST["task_card"], $_POST["id_list"], $_POST["task_duration"] ,$_POST["status_select"], $_POST["id"]);
    }elseif(isset($_POST["delete_task"])){
        delete_task($_POST["id"], $_POST["id_list"]);
    }
    
}elseif($_SERVER["REQUEST_METHOD"] == "GET"){
    echo "Werkttttt";
    $condition = true;
}else {
    $condition = false;
}

$sortparam = isset($_POST["sortbydur"]) ? $_POST["sortbydur"] : "ASC"; 
echo $sortparam;

$filterparam = isset($_POST["filterselect"]) ? $_POST["filterselect"] : "none"; 
?>


<div style="background:[ whitesmoke;" class="w3-bar w3-center">
    <h1 class="">Overview lists<a class="w3-right w3-button w3-blue" href="create_list.php">+</a></h1>
</div>
<!-- <div class="w3-margin-top w3-container w3-center">
    <div id="vak1" class="w3-third">
        <h4 class="w3-red w3-padding">Lijstvak 1</h4>
    </div>

    <div id="vak2" class="w3-third">
        <h4 class="w3-pink w3-padding">Lijstvak 2</h4>
    </div>

    <div id="vak3" class="w3-third">
        <h4 class="w3-green w3-padding">Lijstvak 3</h4>
    </div>
</div> -->
<div id="card-container" class="w3-container w3-center">
    <?php foreach($listdata as $data => $d){ ?>
        <div class="w3-card-2 w3-center w3-third w3-small w3-margin">
            <div class="w3-container w3-blue">
                <h5 class="title"><?=$d["listname"]?><a href="delete_list.php?id=<?= $d["id"]?>"><svg style="width: 5%;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="w3-right svg-inline--fa fa-trash-alt fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg></a><a href="edit_list.php?id=<?= $d["id"]?>"><svg aria-hidden="true" focusable="false" style="width: 5%;" data-prefix="fas" data-icon="pencil-alt" class="w3-right svg-inline--fa fa-pencil-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg></a><a href="page_overview.php?add=yes&id=<?= $d['id']?>"><svg xmlns="http://www.w3.org/2000/svg" id="root" version="1.1" style="width: 5%;" class="w3-right" viewBox="0 0 13 13"><path fill="none" stroke="currentColor" d="M 6.5 1 V 12 M 1 6.5 H 12"/></svg></a></h5>
            </div>

            <div class="w3-white">
                <div class="card-header">
                    <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                        <p><?=$d["listvalue"]. "<br>" ?></p>
                        <select name="filterselect" id="filterselect">
                            <option value="none">None</option>
                            <option value="Todo">To do</option>
                            <option value="In progress..">In progress..</option>
                            <option value="Done!">Done</option>
                        </select>
                        <input type="hidden" name="listid" value="<?=$d["id"]?>">
                        <button name="filter" type="submit">filter</button>
                        <input type="hidden" value="<?= $_POST['status_select']?>" name="">
                        <button name="sortbydur" value="<?= isset($_POST["sortbydur"]) && $_POST["sortbydur"] == "ASC" ? "DESC" : "ASC" ?>" type="submit">sort by duration</button>
                    </form>
                </div>

                <div>
                    <?php 
                    if(isset($_POST["filterselect"])){
                        $filtered_data= filter_tasks($_POST["listid"], $filterparam, $sortparam);
                        foreach($filtered_data as $data3 => $h){ ?>
                                <!-- contentEditable="true" onMouseOver="this.style.color='green'" onMouseOut="this.style.color='black'"  -->
                            <div style="background-color: whitesmoke; padding: 2px;"class="w3-margin-bottom">
                                <div class="w3-center">
                                    <span ><?=$h["taskname"]?></span> <br>
                                    <span ><?=$h["duration"]. "mins" ?></span> <br>
                                    <span ><?=$h["status"]?></span> <br>
                                </div>
                                <br>
                                <a class="w3-left w3-blue" href="page_overview.php?edit=<?=true?>&id=<?=$d["id"]?>&real_id=<?=$e["id"]?>"><svg aria-hidden="true" focusable="false" style="width: 5%;" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg></a>
                            </div>
                  <?php } 
                    }else{
                        $task_data= filter_tasks($d["id"], $filterparam, $sortparam);
                        foreach($task_data as $data2 => $e){ ?>
                                <!-- contentEditable="true" onMouseOver="this.style.color='green'" onMouseOut="this.style.color='black'"  -->
                            <div style="background-color: whitesmoke; padding: 2px;"class="w3-margin-bottom">
                                <div class="w3-center">
                                    <span ><?=$e["taskname"]?></span> <br>
                                    <span ><?=$e["duration"]. "mins" ?></span> <br>
                                    <span ><?=$e["status"]?></span> <br>
                                </div>
                                <br>
                                <a class="w3-left w3-blue" href="page_overview.php?edit=<?=true?>&id=<?=$d["id"]?>&real_id=<?=$e["id"]?>"><svg aria-hidden="true" focusable="false" style="width: 5%;" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg></a>
                            </div>
                 <?php } 
                    } ?>

                <?php if ((isset($_GET["add"]) && $_GET["add"] == "yes") && $d["id"] == $_GET["id"]){ ?>
                    <div>
                        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                            <input type="text" name="task_card" id="">
                            <input type="number" name="task_duration" id="" placeholder="Duur in minuten">
                            <select name="status_select" id="status_selector">
                                <option value="'Todo'">To do</option>
                                <option value="'In progress..'">In progress</option>
                                <option value="'Done!'">Done</option>
                            </select>
                            <input type="hidden" name="id_list" value="<?=$d["id"]?>">
                            <button name="task_submit" type="submit">Add</button>
                            <button type="task_cancel">Cancel</button>
                        </form>
                    </div>
                <?php } elseif((isset($_GET["edit"]) && $_GET["edit"] == true)){ 
                            $edit_data= getTask($_GET["id"], $_GET["real_id"]);
                            foreach($edit_data as $o){ 
                        ?>
                    <div>
                        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                            <input type="text" name="task_card" id="" value="<?=$o["taskname"]?>">
                            <input type="number" name="task_duration" id="" value="<?=$o["duration"]?>">
                            <select name="status_select" id="status_selector" value="<?=$o["status"]?>">
                                <option value="Todo">To do</option>
                                <option value="In progress..">In progress</option>
                                <option value="Done!">Done</option>
                            </select>
                            <input type="hidden" name="id" value="<?=$o["id"]?>">
                            <input type="hidden" name="id_list" value="<?=$o["list_id"]?>">
                            <button name="edit_submit" type="submit">Edit</button>
                            <button type="">Cancel</button>
                            <button name="delete_task" type="submit">Delete</button>
                        </form>
                    </div>    
                <?php  } } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- <a href="create_list.php" class="w3-button w3-blue">Add list</a> -->
</div>

</body>
</html>