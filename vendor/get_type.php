<?php 
require "connect.php";
// // на какие данные рассчитан этот скрипт 
// header("Content-Type: application/json");
// получаем переданный контент
$data = file_get_contents("php://input");

// делаем запрос в БД используя полученные данные
// получаем список типов оборудования
$var = mysqli_query($connect, "SELECT `name` FROM `etype`");
$etypes = [];
while($var_etype = mysqli_fetch_assoc($var)){
    $etypes[] = $var_etype['name'];
}

// генерируем строку с опциями из списка типов
$string_option = ' ';
for($i=0; $i< count($etypes); $i++){
    $string_option = $string_option . "<option>" . $etypes[$i] . "</option>";
}

// передаем полученную строку
echo $string_option;

?>