<?php 
require "connect.php";
// на какие данные рассчитан этот скрипт 
header("Content-Type: application/json");
// получаем переданный контент
$data = file_get_contents("php://input");
// делаем запрос в БД используя полученные данные
// получаем id типа оборудования 
$var = mysqli_query($connect, "SELECT `id` FROM `etype` WHERE `name`='$data'");
$var_id = mysqli_fetch_assoc($var);
$etype_id = $var_id['id'];
// получаем id статуса оборудования
$var2 = mysqli_query($connect, "SELECT `id` FROM `estatus` WHERE `name`='in_stock'");
$var2_id = mysqli_fetch_assoc($var2);
$estatus_id = $var2_id['id'];
// получаем список марок оборудования
$var3 = mysqli_query($connect, "SELECT DISTINCT `emake` FROM `equipment` WHERE `etype_id`='$etype_id' && `estatus_id`='$estatus_id'");
$emakes = [];
while($var_emake = mysqli_fetch_assoc($var3)){
    $emakes[] = $var_emake['emake'];
}
// генерируем строку с опциями из списка марок
$string_option = ' ';
for($i=0; $i< count($emakes); $i++){
    $string_option = $string_option . "<option>" . $emakes[$i] . "</option>";
}
// передаем полученную строку
echo $string_option;

?>