<?php
require_once "../vendor/connect.php";
$ecategory = mysqli_query($connect, "SELECT * FROM `ecategory`");

$etype = mysqli_query($connect, "SELECT * FROM `etype`");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../node_modules/bootstrap/dist/css/bootstrap-grid.css" rel="stylesheet">
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script async src="Search.js"></script>
	<title>Equipment</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-auto">
                <a href="Main.html"><button class="btn btn-outline-secondary">На главную</button></a>
            </div>
			<div class="col input-group">
				<button class="btn btn-outline-info" type="button" id="buttonsearch">Поиск</button>
				<input type="text" class="form-control" id="searchEquipment" placeholder="Введите серийный номер" aria-describedby="button-addon1">
			</div>
		</div>
		<div class="row" style="justify-content: center; margin-bottom: 10px;">
			<h1>Добавить оборудование на склад</h1>
		</div>
		<form action="../vendor/add_equipment.php" method="POST">
		<div class="row" style="margin-bottom: 10px">
			<div class="col">
				<label for="categoryList" class="form-label">Категория оборудования</label>
				<input class="form-control" list="categorylistOptions" id="categoryList" name="ecategory" placeholder="category">
				<datalist id="categorylistOptions">
					<?php 
					while($var = mysqli_fetch_assoc($ecategory)){
						echo '<option value='.$var["name"].'>';
					}
					?>
				</datalist>
			</div>
			<div class="col">
				<label for="typeList" class="form-label">Тип оборудования</label>
				<input class="form-control" list="typelistOptions" id="typeList" name="etype" placeholder="type" autocomplete="off" >
				<datalist id="typelistOptions">
				<?php 
					while($var2 = mysqli_fetch_assoc($etype)){
						echo '<option value='.$var2["name"].'>';
					}
					?>
				</datalist>
			</div>
		</div>
		<div class="row" style="margin-bottom: 10px">
			<div class="col">
				<label for="makeList" class="form-label">Марка</label>
				<input class="form-control" type="text" id="makeList" name="emake" placeholder="make">
			</div>
			<div class="col">
				<label for="modelList" class="form-label">Модель</label>
				<input class="form-control" id="modelList" name="emodel" placeholder="model">
			</div>
		</div>
		<div class="row" style=" align-items: flex-end; margin-bottom: 10px">
			<div class="col-1">
				<label for="count" class="form-label">Количество</label>
				<input class="form-control form-control" id = "count" type="enumber" placeholder='1' value="1" aria-label=".form-control example">
			</div>
			<div class="col-1">
				<button type="button" id="+" class="btn btn-outline-info">+</button>
			</div>
			<div class="col">
				<input class="form-control" type="text" placeholder="serial number" name="number" aria-label=".form-control example">
			</div>
		</div>
		<div class="row">
			<div class="col">
				<button type="submit" class="btn btn-outline-danger">ДОБАВИТЬ</button>
			</div>
			<div class="col-md-auto">
                <button type="reset" class="btn btn-outline-secondary">Сбросить</button>
            </div>
		</div>
	</form>
	
	</div>
	<script src="EcuipmentScript.js"></script>
	
</body>
</html>