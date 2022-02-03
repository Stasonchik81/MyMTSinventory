<?php   
require "connect.php";
$ecategory = $_POST['ecategory'];
$etype = $_POST['etype'];
$emake = $_POST['emake'];
$emodel = $_POST['emodel'];
$enumbers = array_filter($_POST, "getNumber", ARRAY_FILTER_USE_KEY);

function getNumber($key){
    return str_contains($key, 'number');
}


$var = mysqli_query($connect, "SELECT `id` FROM `ecategory` where `name`='$ecategory'");
$var_id = mysqli_fetch_assoc($var);
$ecategory_id = $var_id['id'];
$var2 = mysqli_query($connect, "SELECT `id` FROM `etype` where `name`='$etype'");
$var2_id = mysqli_fetch_assoc($var2);
$etype_id = $var2_id['id'];
$var2->close();

function findNumber($number, $connect){
    $row_number = mysqli_query($connect, "SELECT * FROM `equipment` where `serial`='$number'");
    if($row_number->num_rows > 0){
        $number_id = mysqli_fetch_assoc($row_number);
        $number_id = $number_id['id'];
        return $number_id;
    }
    $row_number->close();
}

foreach ($enumbers as $value){
    if(findNumber($value, $connect)){
        $id = findNumber($value, $connect);
        mysqli_query($connect, "UPDATE `equipment` SET `ecategory_id`='$ecategory_id', `etype_id`='$etype_id', `emake`='$emake', `emodel`='$emodel' WHERE `id`= $id");
    }
    else{
        mysqli_query($connect, "INSERT INTO `equipment` (`ecategory_id`, `etype_id`, `emake`, `emodel`, `serial`) VALUES ('$ecategory_id', '$etype_id', '$emake', '$emodel', '$value') ");
    }
}

header('Location: ../content/equipment.php');
?>
