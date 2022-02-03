<?php 
require "connect.php";
// на какие данные рассчитан этот скрипт 
header("Content-Type: application/json");
// получаем переданный контент
$data = file_get_contents("php://input");

// делаем запрос в БД используя полученные данные
// получаем список моделей оборудования
$var = mysqli_query($connect, "SELECT DISTINCT `emodel` FROM `equipment` WHERE `emake`='$data'");
$emodels = [];
while($var_emodel = mysqli_fetch_assoc($var)){
    $emodels[] = $var_emodel['emodel'];
}

// генерируем строку с опциями из списка моделей
$string_option = ' ';
for($i=0; $i< count($emodels); $i++){
    $string_option = $string_option . "<option>" . $emodels[$i] . "</option>";
}

// передаем полученную строку
echo $string_option;

?>