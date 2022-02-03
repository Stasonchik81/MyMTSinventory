<?php   
require "connect.php";
require_once '../classes/Equipment.php';
header("Content-Type: application/json");
$data = file_get_contents("php://input");

// делаем запрос в БД используя полученные данные
// Реализовать вариант ввода несуществующего номера.................!
$equipment_id = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `serial`='$data'");
$id = mysqli_fetch_assoc($equipment_id);
$id = $id['id'];
$myEquipment = new Equipment($id, $connect);
echo(json_encode($myEquipment));

?>