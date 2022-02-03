<?php
require "../vendor/connect.php";
class Equipment{
    public $category;
    public $type;
    public $make;
    public $model;
    public $serial;
    public $status;
    public $id = 'ID';
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