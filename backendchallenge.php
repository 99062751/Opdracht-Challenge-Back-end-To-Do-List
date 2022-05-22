<?php
//console.log om dingen te loggen is makkelijker voor mezelf
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>'; 
    }
    echo $js_code;
}

/*============ Connectie met database ===============*/
function connect(){
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "backendchallengedb";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}
function controle(){
    $id= $_GET["id"];
    echo $id;
    $name= $_POST["list_name"];
    $value= $_POST["list_value"];    
    $list_newname= $_POST["list_newname"];
    $list_newvalue= $_POST["list_newvalue"];
    if ((!empty($name) && !empty($value)) || !empty($list_newname) && !empty($list_newvalue)) {
        return true;
    }else{
        return false;
    }
}

function addList($list_name, $list_value){    
    try {
        $conn= connect();

        $stmt = $conn->prepare("INSERT INTO `list_info`(listname,listvalue) VALUES(:list_name,:list_value)");
        $stmt->bindParam(':list_name', $list_name);
        $stmt->bindParam(':list_value', $list_value);

        $stmt->execute();

        $conn = null;
        return [true, "Succesfully added list!"];
    } catch (Exeception $err) {
        return [false, $err->getMessage()];
    }
}

function updateList($list_newname, $list_newvalue, $ID){ 
    try {
        $conn= connect();

        $stmt = $conn->prepare("UPDATE `list_info` SET listname=:list_name, listvalue=:list_value WHERE id=:id");
        $stmt->bindParam(':list_name', $list_newname);
        $stmt->bindParam(':list_value', $list_newvalue);
        $stmt->bindParam(':id', $ID);

        $stmt->execute();

        $conn = null;
        return [true, "Succesfully updated list!"];
    } catch (Exeception $err) {
        return [false, $err->getMessage()];
    }
}

function deleteList($ID){ 
       
    try {
        try{
            $conn= connect();

            $stmt = $conn->prepare("DELETE FROM `task_info` WHERE list_id=:id_list");
            $stmt->bindParam(':id_list', $ID);
            $stmt->execute();
            
            $conn = null;

            $conn= connect();

            $stmt = $conn->prepare("DELETE FROM `list_info` WHERE id=:id");
            $stmt->bindParam(':id', $ID);

            $stmt->execute();

            $conn = null;
            return [true, "Succesfully removed list!"];
        } catch (Exeception $err){
            $conn= connect();

            $stmt = $conn->prepare("DELETE FROM `list_info` WHERE id=:id");
            $stmt->bindParam(':id', $ID);

            $stmt->execute();

            $conn = null;
            return [true, "Succesfully removed list!"];
        }
    } catch (Exeception $err) {
        return [false, $err->getMessage()];
    }
}

function getLists(){
    $conn= connect();

    $stmt = $conn->prepare("SELECT * FROM list_info");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $conn = null;
    return $data;
}

function getOneList($id){
    $conn= connect();

    $stmt = $conn->prepare("SELECT * FROM list_info WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn = null;
    return $data;
}


function addTask($task_name, $list_id, $duration, $status){    
    try {
        $conn= connect();

        $stmt = $conn->prepare("INSERT INTO `task_info`(taskname, list_id, duration, status) VALUES(:task_name, :list_id, :duration, :status)");
        $stmt->bindParam(':task_name', $task_name);
        $stmt->bindParam(':list_id', $list_id);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':status', $status);

        $stmt->execute();

        $conn = null;
        return [true, "Succesfully added task!"];
    } catch (Exeception $err) {
        return [false, $err->getMessage()];
    }
}

function getTask($id_list, $real_id){
    $conn= connect();

    $stmt = $conn->prepare("SELECT * FROM task_info WHERE list_id= :list_id AND id=:real_id");
    $stmt->bindParam(':list_id', $id_list);
    $stmt->bindParam(':real_id', $real_id);
    
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $real_id= "";
    $conn = null;
    return $data;
}

function getAllTasks($id_list){
    $conn= connect();

    $stmt = $conn->prepare("SELECT * FROM task_info WHERE list_id= :list_id");
    $stmt->bindParam(':list_id', $id_list);
    
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    return $data;
}

function updateTask($task_name, $list_id, $duration, $status, $id){
    try {
        $conn= connect();

        $stmt = $conn->prepare("UPDATE `task_info` SET taskname= :task_name, list_id=:list_id, duration=:duration, status=:status WHERE id=:id");
        $stmt->bindParam(':task_name', $task_name);
        $stmt->bindParam(':list_id', $list_id);
        $stmt->bindParam(':duration', $duration);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $conn = null;
        return [true, "Succesfully updated task!"];
    } catch (Exeception $err) {
        return [false, $err->getMessage()];
    }
}

function delete_task($id, $id_list){
    try{
        $conn= connect();

        $stmt = $conn->prepare("DELETE FROM `task_info` WHERE id=:id AND list_id=:id_list");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_list', $id_list);
        $stmt->execute();
        
        $conn = null;
        return [true, "Succesfully removed task!"];
    } catch (Exeception $err) {
        return [false, $err->getMessage()];
    }
}



function filter_tasks($id_list, $filter){
    if(is_null($filter) || empty($filter) || $filter == "none"){
        echo "filter= none or status";
        $conn= connect();

        $stmt = $conn->prepare("SELECT * FROM task_info WHERE list_id= :list_id");
        $stmt->bindParam(':list_id', $id_list);
        
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        return $data;
    }else{
        echo "test";
        try {
            $conn= connect();
            $stmt = $conn->prepare("SELECT * FROM task_info WHERE list_id = :list_id ORDER BY status :fil");
            
            $stmt->bindParam(':list_id', $id_list);
            $stmt->bindParam(':fil', $filter);
    
            $stmt->execute();
            echo "works, function executed";
            $conn = null;
        } catch (Exeception $err) {
            return [false, $err->getMessage()];
        }
    }
}