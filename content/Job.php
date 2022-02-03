<?php
require_once "../vendor/connect.php";
$etype = mysqli_query($connect, "SELECT * FROM `etype`");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../node_modules/bootstrap/dist/css/bootstrap-grid.css" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="content.css">
    <script async src="Job.js"></script>
    
    <title>Add_Job</title>
</head>
<body>
    <div class="container">
        <div class="row">
			<div class="col-md-auto">
                <a href="Main.html"><button class="btn btn-outline-secondary">На главную</button></a>
            </div>
		</div>
        <div class="row headOn">
            <h1>Добавить наряд</h1>
        </div>
        <form class="row" action="../vendor/add_job.php" method="POST" id="main-form">
            <div class="col-md-2">
              <label for="date" class="form-label">Дата</label>
              <input type="text" class="form-control" id="date" name='date'>
            </div>
            <div class="col-md-2">
              <label for="contract" class="form-label">Договор</label>
              <input type="text" class="form-control" id="contract" name='contract'>
            </div>
            <div class="col-md-8 marginAuto">
                <div class="input-group">
                    <span class="input-group-text marginAuto" style="height: 50%">Адрес</span>
                    <div class="col-6" style="padding: 0;">
                        <label for="street" class="form-label">Улица</label>
                        <input type="text" class="form-control" id="street" name='street'>
                    </div>
                    <div class="col-2" style="padding: 0;">
                        <label for="building" class="form-label">Дом</label>
                        <input type="text" class="form-control" id="building" autocomplete="off" name='building'>
                    </div>
                    <div class="col" style="padding: 0;">
                        <label for="corp" class="form-label">Корпус</label>
                        <input type="text" class="form-control" id="corp" autocomplete="off" name='corp'>
                    </div>
                    <div class="col" style="padding: 0;">
                        <label for="flat" class="form-label">Квартира</label>
                        <input type="text" class="form-control" id="flat" autocomplete="off" name='flat'>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-12">
                <h4>Подключенные услуги</h4>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="CTV" id="CTV" name=services>
                    <label class="form-check-label" for="CTV">
                      ЦТВ
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" value="Ethernet" id="Ethernet" name=services>
                    <label class="form-check-label" for="Ethernet">
                      ШПД
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="CTV+Ethernet" id="CTV+Ethernet" name=services checked>
                    <label class="form-check-label" for="CTV+Ethernet">
                        ЦТВ+ШПД
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="CTV+Ethernet+Phone" id="CTV+Ethernet+Phone" name=services>
                    <label class="form-check-label" for="CTV+Ethernet+Phone">
                        ЦТВ+ШПД+ТЛФ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Service" id="Service" name=services>
                    <label class="form-check-label" for="Service">
                        Сервис
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check" style="line-height: 2em;" id="no_equipment">
                        <input class="form-check-input" type="checkbox" value="on" name='no_equipment' style="margin-top: 10px;">
                        <label class="form-check-label" for="no_equipment">
                        Без оборудования
                        </label>
                </div>
                <div class="form-check hide" style="line-height: 2em;" id="return">
                        <input class="form-check-input" type="checkbox" value="on" name='return' style="margin-top: 10px;">
                        <label class="form-check-label" for="return">
                        Возврат
                        </label>
                </div>
            </div>
            <div class="col-md-3 checkbox">
                <div class="form-check" style="line-height: 2em;">
                    <input class="form-check-input" type="checkbox" value="on" name='sim' id="checkSim" style="margin-top: 10px;">
                    <label class="form-check-label" for="checkSim">
                      Сим-карта
                    </label>
                </div>
                <div class="form-check" style="line-height: 2em;">
                    <input class="form-check-input" type="checkbox" value="on" name='add_tv' id="checkTv" style="margin-top: 10px;">
                    <label class="form-check-label" for="checkTv">
                      Доп.ТВ
                    </label>
                </div>
                <div class="form-check" style="line-height: 2em;">
                    <input class="form-check-input" type="checkbox" value="on" name='add_router' id="checkConfRouter" style="margin-top: 10px;">
                    <label class="form-check-label" for="checkConfRouter">
                      Настройка роутера
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-control count" type="number" name='sim_number' value="1" id="checkSimCount" disabled>
                    <label for="sim_number">
                        Кол-во
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-control count" type="number" name='tv_number' value="1" id="checkTvCount" disabled>
                    <label for="tv_number">
                        Кол-во
                    </label>
                </div>
                <div class="form-check">
                    <input type="text" class="form-check-control" name='router' id="checkConfRouterCount" disabled>
                    <label for="router" class="form-label">Модель</label>  
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-12">
                <h4>Оборудование</h4>
            </div>
            <div class="col-md-10 inrow spaceBetween">
                <div class="incol">
                    <select class="form-select" id="select_type" name="type1">
                    <?php 
                
					    while($var2 = mysqli_fetch_assoc($etype)){
                            echo '<option>'. $var2["name"] . '</option>';
                        }
                        
					?>
                      </select>
                      <label for="select_type">Выбери тип</label>
                </div>
                <div class="incol">
                    <select class="form-select" id="select_make" name="make1">
                        
                      </select>
                      <label for="select_make">Выбери марку</label>
                </div>
                <div class="incol">
                    <select class="form-select" id="select_model" name="model1">
                        
                      </select>
                      <label for="select_model">Выбери модель</label>
                </div>
                <div class="incol">
                    <select class="form-select" id="select_number" name="number1">
                        
                      </select>
                      <label for="select_number">Выбери серийный номер</label>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" id="+" class="btn btn-outline-info">+</button>
            </div>
            <!-- генерируемая часть -->
            
            <div class="col-md-12" id="end">
                <hr>
                <h4>Возврат</h4>
            </div>
            <div class="col-md-12 inrow spaceBetween">
                <div class="incol hide">
                    <select class="form-select" id='type' name="type_r">
                    <?php 
                        $var2 = mysqli_query($connect, "SELECT * FROM `etype`");
					    while($variables = mysqli_fetch_assoc($var2)){
                            echo '<option>'. $variables["name"] . '</option>';
                        }
					?>
                      </select>
                      <label for="type">Выбери тип</label>
                </div>
                <div class="incol hide">
                    <input class="form-control-sm" type="text" id='make' name="make_r">
                    <label for="make">Марка</label>
                </div>
                <div class="incol hide">
                    <input class="form-control-sm" type="text" id="model" name="model_r">
                    <label for="model">Модель</label>
                </div>
                <div class="incol hide">
                    <input class="form-control-sm" type="text" id="number" name="number_r">
                    <label for="number">Серийный номер</label>
                </div>
                <div class="incol hide">
                <button type="button" id="+return" class="btn btn-outline-info">+</button>
                </div>
            </div>
            <!-- генерируемая часть -->
            <div class="col-md-12" id="end_return">
                <hr>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-outline-danger">Добавить</button>
            </div>
            <div class="col-md-auto">
                <button type="reset" class="btn btn-outline-secondary">Сбросить</button>
            </div>
        </form>
    </div>
    
</body>
</html>