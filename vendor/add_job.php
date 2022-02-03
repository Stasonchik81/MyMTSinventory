<?php   
require "connect.php";
$date = $_POST['date'];
$contract = $_POST['contract'];
$street = $_POST['street'];
$building = $_POST['building'];
if($_POST['corp'] !== ''){
    $building = $building . 'k' . $_POST['corp'];
}
$flat = $_POST['flat'];

// Вносим данные договора в таблицу contract
$var_contr = mysqli_query($connect, "SELECT `contract` FROM `contract` where `contract`='$contract'");
$var2_contr = mysqli_fetch_assoc($var_contr);

if(is_null($var2_contr)){
    mysqli_query($connect, "INSERT INTO `contract` (`contract`, `street`, `building`, `flat`) VALUES ('$contract', '$street', '$building', '$flat')");
}


// Получаем id договора (contract_id)
$var = mysqli_query($connect, "SELECT `id` FROM `contract` where `contract`='$contract'");
$var_id = mysqli_fetch_assoc($var);
$contract_id = (int)$var_id['id'];


// Получаем status_id для статуса выполнен из таблицы status
$var2 = mysqli_query($connect, "SELECT `id` FROM `status` where `namestatus`='выполнен'");
$var2_id = mysqli_fetch_assoc($var2);
$status_id = +$var2_id['id'];

//Получаем service_id из таблицы services
$services = $_POST['services'];
$var3 = mysqli_query($connect, "SELECT `id` FROM `services` where `name`='$services'");
$var3_id = mysqli_fetch_assoc($var3);
$services_id = +$var3_id['id'];

//Получаем данные о доп услугах
if(isset($_POST['sim'])){
    $sim_count = +$_POST['sim_number'];
}
else{
    $sim_count = 0;
}
if(isset($_POST['add_tv'])){
    $tv_count = +$_POST['tv_number'];
}
else{
    $tv_count = 0;
}
if(isset($_POST['add_router'])){
        $router = 1;
}
else{
    $router = 0;
}

// Преобразуем время в нужный формат
$time = strtotime($date); 
$newdate = date('Y.m.d',$time);

//Вносим данные в таблицу jobs
mysqli_query($connect, "INSERT INTO `jobs` (`date`, `contract_id`, `status_id`, `services_id`, `sim`, `addtv`, `confrouter`) VALUES ('$newdate', $contract_id, $status_id, $services_id, $sim_count, $tv_count, $router)");

//Получаем серийные номера оборудования
$enumbers = array_filter($_POST, "getNumber", ARRAY_FILTER_USE_KEY);

function getNumber($key){
    return str_contains($key, 'number');
}
//Получаем id из таблицы estatus для name='installed'
$var4 = mysqli_query($connect, "SELECT `id` FROM `estatus` where `name`='installed'");
$var4_id = mysqli_fetch_assoc($var4);
$estatus_id = +$var4_id['id'];

//В таблице equipment меняем estatus_id у оборудования с соответствующими серийниками и 
//устанавливаем соответствующий contract_id
foreach ($enumbers as $value){
    mysqli_query($connect, "UPDATE `equipment` SET `estatus_id` = $estatus_id, `contract_id` = $contract_id WHERE (`serial` = '$value')");
}

// Работа с возвратом____________
if($_POST['make_r']){
    $types_r = array_filter($_POST, "getTypes_r", ARRAY_FILTER_USE_KEY);
    $types_r = array_values($types_r);
    
    // Получаем id типов оборудования
    $types_r_ids = [];
    for($i=0; $i<count($types_r); $i++){
    $var_types_r = mysqli_query($connect, "SELECT `id` FROM `etype` where `name`='$types_r[$i]'");
    $var_types_r_id = mysqli_fetch_assoc($var_types_r);
    $types_r_ids[] += $var_types_r_id['id'];
    }
    // Получаем массивы производителей и соответствующих моделей
    $makes_r = array_filter($_POST, "getMaker_r", ARRAY_FILTER_USE_KEY);
    $makes_r = array_values($makes_r);
    $models_r = array_filter($_POST, "getModel_r", ARRAY_FILTER_USE_KEY);
    $models_r = array_values($models_r);

    // Получаем id категории оборудования
    $var_categores = mysqli_query($connect, "SELECT `id` FROM `ecategory` where `name`='бу'");
    $var_category_id = mysqli_fetch_assoc($var_categores);
    $category_id = $var_category_id['id'];
    
    // Получаем id статуса оборудования
    $var_statuses = mysqli_query($connect, "SELECT `id` FROM `estatus` where `name`='returned'");
    $var_status_id = mysqli_fetch_assoc($var_statuses);
    $status_id = $var_status_id['id'];
    
    // Получаем массив серийников возвращаемого оборудования
    $enumbers_r = array_filter($_POST, "getNumber_r", ARRAY_FILTER_USE_KEY);
    $enumbers_r = array_values($enumbers_r);
    // $enumbers_r = getItems('number_r');
    
    // Добавляем в базу возвращенное оборудование
    for($i=0; $i<count($enumbers_r); $i++){
    mysqli_query($connect, "INSERT INTO `equipment` (`ecategory_id`, `etype_id`, `emake`, `emodel`, `serial`, `estatus_id`, `contract_id`) VALUES ('$category_id', '$types_r_ids[$i]', '$makes_r[$i]', '$models_r[$i]', '$enumbers_r[$i]', '$status_id', $contract_id)");
    }
}

function getNumber_r($key){
    return str_contains($key, 'number_r');
}
function getTypes_r($key){
    return str_contains($key, 'type_r');
}
function getMaker_r($key){
    return str_contains($key, 'make_r');
}
function getModel_r($key){
    return str_contains($key, 'model_r');
}









header('Location: ../content/Job.php');
?>