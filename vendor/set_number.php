<?php 
require "connect.php";
// на какие данные рассчитан этот скрипт 
header("Content-Type: application/json");
// получаем переданный контент
$data = file_get_contents("php://input");

// делаем запрос в БД используя полученные данные

// получаем id статуса оборудования
$var = mysqli_query($connect, "SELECT `id` FROM `estatus` WHERE `name`='in_stock'");
$var_id = mysqli_fetch_assoc($var);
$estatus_id = $var_id['id'];

// получаем список номеров оборудования
$var2 = mysqli_query($connect, "SELECT `serial` FROM `equipment` WHERE `emodel`='$data' && `estatus_id`=$estatus_id");
$enumbers = [];
while($var_serial = mysqli_fetch_assoc($var2)){
    $enumbers[] = $var_serial['serial'];
}

// генерируем строку с опциями из списка моделей
$string_option = ' ';
for($i=0; $i< count($enumbers); $i++){
    $string_option = $string_option . "<option>" . $enumbers[$i] . "</option>";
}

// передаем полученную строку
echo $string_option;

?>