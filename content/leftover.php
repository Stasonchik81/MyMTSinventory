<?php 
require_once "../vendor/connect.php";
    
    //Получаем текущую дату
    $now = new DateTime();
    $now = $now->format('d.m.Y');
    
    // получаем id статуса для оборудования в наличии
    $status = mysqli_query($connect, "SELECT `id` FROM `estatus` where `name`='in_stock'");
    $var_id = mysqli_fetch_assoc($status);
    $estatus_id = +$var_id['id'];
    
    // из таблицы equipments получаем все строки c оборудованием в наличии и не брак
    $my_equipments = mysqli_query($connect, "SELECT * FROM `equipment` WHERE `estatus_id`=$estatus_id AND `ecategory_id`!=3");


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../node_modules/bootstrap/dist/css/bootstrap-grid.css" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">  
    <title>LeftOver</title>
</head>
<body>
    <div class="container">
      <div class="row">
        <div class="col-md-auto">
          <a href="Main.html"><button class="btn btn-outline-secondary">На главную</button></a>
        </div>
      </div>
        <h1>Наличие оборудования</h1>
        <p>По состоянию на: <span>
        <?php
            echo $now;
        ?>
        </span></p>

        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">№ п/п</th>
                <th scope="col">Тип</th>
                <th scope="col">Категория</th>
                <th scope="col">Марка</th>
                <th scope="col">Модель</th>
                <th scope="col">Серийник</th>
              </tr>
            </thead>
            <tbody>
            <!-- генерация строк таблицы -->
            <?php
            if(isset($my_equipments)){
                $count = 1; // счётчик строк таблицы
                while($vars = mysqli_fetch_assoc($my_equipments)){
                    $var_etype = mysqli_query($connect, "SELECT `name` FROM `etype` WHERE `id`= $vars[etype_id]");
                    $etype = mysqli_fetch_assoc($var_etype);
                    $etype = $etype["name"]; 
                    $var_ecategory = mysqli_query($connect, "SELECT `name` FROM `ecategory` WHERE `id`= $vars[ecategory_id]");
                    $ecategory = mysqli_fetch_assoc($var_ecategory);
                    $ecategory = $ecategory["name"];
                    $make = $vars["emake"];
                    $model = $vars["emodel"];
                    $number = $vars["serial"];
                    echo '<tr>
                    <th scope="row">' . $count . '</th>
                    <td>' . $etype . '</td>
                    <td>' . $ecategory . '</td>
                    <td>' . $make . '</td>
                    <td>' . $model . '</td>
                    <td>' . $number . '</td>
                  </tr>';
                  $count++;
                } 
            }
                
            ?> 
            </tbody>
          </table>
      </div>
</body>
</html>