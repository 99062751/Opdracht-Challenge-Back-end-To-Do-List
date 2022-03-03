<?php  
require "backendchallenge.php";
$listdata= getLists();
require "templates/header.php";

?>

<div style="background: whitesmoke;" class="w3-bar w3-center">
    <h1 class="">Overview lists</h1>
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
                <p><?=$d["listvalue"]. "<br>" ?></p>
                <?php if ((isset($_GET["add"]) && $_GET["add"] == "yes") && $d["id"] == $_GET["id"]){ ?>
                    <div>
                        <textarea name="task_card" id="s" cols="15" rows="3"></textarea>
                        <button name="task_submit" type="submit">Add</button>
                        <button type="task_cancel">Cancel</button>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <!-- <a href="create_list.php" class="w3-button w3-blue">Add list</a> -->
</div>

<?php require "templates/footer.php" ?>