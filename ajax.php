<?php
//sleep(2);
require_once "lib/database_class.php";
require_once "lib/config_class.php";
$db = new DataBase();
$config = new Config();

if(isset($_POST["ter"])) $ter = $_POST["ter"];
$data = $db->select("users", array('*'), "", "", "`login`='$ter'");
echo json_encode($data[0]);