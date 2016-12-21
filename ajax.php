<?php
sleep(2);
require_once "lib/database_class.php";
require_once "lib/config_class.php";
$db = new DataBase();
$config = new Config();

if(isset($_POST["login"])) $login = $_POST["login"];
$data = $db->select("users", array('*'), "", "", "`login`='$login'");
if($data[0]){
    echo "no";
}
else {echo "yes";}
//echo json_encode($data[0]);