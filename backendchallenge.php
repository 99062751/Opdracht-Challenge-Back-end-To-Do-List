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

$name= $_POST["list_name"];
$value= $_POST["list_value"];
    if((isset($name) || isset($name)) && $_GET["confirm"] == 'yes'){
        addList($name, $value);
    }elseif ($_GET["confirm"] == 'yes') {
        $data= getLists();
        echo $data; 
    }

function addList($list_name, $list_value){
    try {
        $conn= connect();
        $stmt = $conn->prepare("INSERT INTO `list_info`(listname,listvalue) VALUES(:list_name,:list_value)");
        $stmt->bindParam(':listname', $list_name);
        $stmt->bindParam(':list_value', $list_value);
        $stmt->execute();
        console_log("ERROR IETS WERKT NIET");

        $conn = null;
    } catch (\Throwable $th) {
        return $th;
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
