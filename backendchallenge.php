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
       echo "aasje=". $ID;
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
        $conn= connect();

        $stmt = $conn->prepare("DELETE FROM `list_info` WHERE id=:id");
        $stmt->bindParam(':id', $ID);

        $stmt->execute();

        $conn = null;
        return [true, "Succesfully removed list!"];
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
