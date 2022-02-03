<?php 
require_once "../vendor/connect.php";
function convert_Date ($format, $myDate){
    $my_time = strtotime($myDate);
    $new_date = date($format, $my_time);
    return $new_date;
}
if(isset($_REQUEST['start']) && isset($_REQUEST['end'])){
    $first_date = $_REQUEST['start'];
    $second_date = $_REQUEST['end'];
    // из таблицы jobs получаем все строки в указанном диапазоне
    $my_jobs = mysqli_query($connect, "SELECT * FROM `jobs` WHERE `date` BETWEEN '$first_date' AND '$second_date'");
    
}
// создать класс "оборудование"
class Equipment {
    public $id = 'ID';
    public $type;
    public $category;
    public $make;
    public $model;
    public $serial;
    public $status;
    public $connect;
    function __construct($id, $connect){
        $this->id = $id;
        $this->connect = $connect;
        $vars = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `id`= '$id'");
        while ($var_equipment = mysqli_fetch_assoc($vars)){
            $vars2 = mysqli_query($connect, "SELECT `name` FROM `etype` WHERE `id`= $var_equipment[etype_id]");
            $row_type = mysqli_fetch_assoc($vars2);
            $this->type = $row_type['name'];
            $vars3 = mysqli_query($connect, "SELECT `name` FROM `ecategory` WHERE `id`= $var_equipment[ecategory_id]");
            $row_category = mysqli_fetch_assoc($vars3);
            $vars4 = mysqli_query($connect, "SELECT `name` FROM `estatus` WHERE `id`= $var_equipment[estatus_id]");
            $row_status = mysqli_fetch_assoc($vars4);
            $this->status = $row_status['name'];
            $this->category = $row_category['name'];
            $this->make = $var_equipment['emake'];
            $this->model = $var_equipment['emodel'];
            $this->serial = $var_equipment['serial'];
        };
    
    }
    function toPrint(){
        return $this->type . " " . $this->category . " " . $this->make . " " . $this->model . " <span>" . $this->serial . "</span><br>";
    }
    function toPrintR(){
        return $this->type . " " . $this->category . " " . $this->make . " " . $this->model . " <span class='returned'>" . $this->serial . "</span><br>";
    }
}

// функция создания строки с оборудованием из массива (для договора)
function get_string($array){
    $myString = '';
    for($i = 0; $i < count($array); $i++){
        if($array[$i]->status === 'returned'){
            $myString = $myString . $array[$i]->toPrintR();
        }
        else{
            $myString = $myString . $array[$i]->toPrint();
        }
    }
    return $myString;
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../node_modules/bootstrap/dist/css/bootstrap-grid.css" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1 span{
            color: rgb(231, 31, 31);
            font-weight: bolder;
        }
        td span{
            font-weight: bolder;
        }
        .returned{
            color: green;
        }
        .returned::after{
            content: " (возврат)";
            color: green;
        }
    </style>  
    <title>Report</title>
</head>
<body>
    <div class="container">
        <div class="row">
			<div class="col-md-auto">
                <a href="Main.html"><button class="btn btn-outline-secondary">На главную</button></a>
            </div>
		</div>
        <p>Выберите отчётный период</p>
        <form action='report.php' method="POST" class="row gx-3">
            <div class="col-md-5">
                <label for="date1" class="form-label">Дата начала:</label>
                <input type="date" id="date1" name="start" class="form-control"/>
            </div>
            <div class="col-md-5">
                <label for="date2" class="form-label">Дата окончания:</label>
                <input type="date" id="date2" name="end" class="form-control"/>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-outline-danger">Ввод</button>
            </div>
        </form>
        <h1>Отчёт за период <span>
        <?php 
        if(isset($first_date) && isset($second_date)){
            $C_first_date = convert_Date('d.m.Y', $first_date);
            $C_second_date = convert_Date('d.m.Y', $second_date); 
            echo $C_first_date . ' - ' . $C_second_date;        }
        else{
            echo 'отчётный период';
        }
        ?>
        </span></h1>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">№ п/п</th>
                <th scope="col">Дата</th>
                <th scope="col">№ договора</th>
                <th scope="col">Тип услуг</th>
                <th scope="col">Оборудование</th>
              </tr>
            </thead>
            <tbody>
            <!-- генерация строк таблицы -->
            <?php
            if(isset($my_jobs)){
                $count = 1; // счётчик строк таблицы
                while($var = mysqli_fetch_assoc($my_jobs)){
                    $contract = mysqli_query($connect, "SELECT `contract` FROM `contract` WHERE `id`= $var[contract_id]");
                    $var2 = mysqli_fetch_assoc($contract);
                    $service = mysqli_query($connect, "SELECT `name` FROM `services` WHERE `id`= $var[services_id]");
                    $var3 = mysqli_fetch_assoc($service);
                    $ids = mysqli_query($connect, "SELECT `id` FROM `equipment` WHERE `contract_id`= $var[contract_id]");
                    $equipments = [];
                    while($var4 = mysqli_fetch_assoc($ids)){
                        $equipment_id = $var4['id'];
                        $equipment = new Equipment($equipment_id, $connect);
                        $equipments[] = $equipment;
                    }
                    $x = get_string($equipments);
                    $date = convert_Date('d.m.Y', $var["date"]);
                    echo '<tr>
                    <th scope="row">' . $count . '</th>
                    <td>' . $date . '</td>
                    <td>' . $var2["contract"] . '</td>
                    <td>' . $var3["name"] . '</td>
                    <td>' . $x . '</td>
                  </tr>';
                  $count++;
                } 
            }
            ?> 
            </tbody>
          </table>
          <h2>ИТОГО УСТАНОВЛЕНО:</h2>
          <table class="table table-bordered">
          <thead>
              <tr>
                <th scope="col">Тип оборудования</th>
                <th scope="col">всего(ед.)</th>
                <th scope="col">новых(ед.)</th>
                <th scope="col">бу(ед.)</th>
              </tr>
            </thead>
            <tbody>
            <!-- генерация строк таблицы ИТОГО-->
            <?php
            if(isset($first_date)&&isset($second_date)){
                $contracts_id = [];
                $my_ids = mysqli_query($connect, "SELECT `contract_id` FROM `jobs` WHERE `date` BETWEEN '$first_date' AND '$second_date'");
                while($variables = mysqli_fetch_assoc($my_ids)){
                    $contracts_id[] = (string)$variables["contract_id"];
                }
                $contracts_id_string = implode(',', $contracts_id);
                $etype = mysqli_query($connect, "SELECT * FROM `etype`");
                $estatusR = mysqli_query($connect, "SELECT * FROM `estatus` WHERE `name` = 'returned'");
                $estatusR_id = mysqli_fetch_assoc($estatusR);
                $estatusR_id = +$estatusR_id['id'];
                $id_in_use = mysqli_query($connect, "SELECT * FROM `ecategory` WHERE `name` = 'бу'");
                $id_in_use = mysqli_fetch_assoc($id_in_use);
                $id_in_new = mysqli_query($connect, "SELECT * FROM `ecategory` WHERE `name` = 'новое'");
                $id_in_new = mysqli_fetch_assoc($id_in_new);
                while($var_type = mysqli_fetch_assoc($etype)){
                    $x = +$var_type['id'];
                    $y = +$id_in_new['id'];
                    $z = +$id_in_use['id'];
                    $var_total = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `contract_id` IN ($contracts_id_string) AND `etype_id` = $x AND `estatus_id`!= $estatusR_id"); // добавить условие
                    $in_total = mysqli_num_rows($var_total);
                    $var_total_inuse = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `contract_id` IN ($contracts_id_string) AND `etype_id` = $x AND `ecategory_id` = $z AND `estatus_id`!= $estatusR_id");
                    $in_total_inuse = mysqli_num_rows($var_total_inuse);
                    $var_total_innew = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `contract_id` IN ($contracts_id_string) AND `etype_id` = $x AND `ecategory_id` = $y");
                    $in_total_innew = mysqli_num_rows($var_total_innew);
                    echo '<tr>
                    <th scope="row">' . $var_type['name'] . '</th>
                    <td>' . $in_total . '</td>
                    <td>' . $in_total_innew . '</td>
                    <td>' . $in_total_inuse . '</td>
                  </tr>';
                };
            }
            ?>
            </tbody>
          </table>
      </div>
</body>
</html>