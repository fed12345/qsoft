<html>
<head>
<title>Qsoft</title>
</head>
<body>





<?php

class QSOFT {

public function treeFunc(){

$tree = array(
'level 1' => array(
'level 1.1',
'level 1.2',
'level 1.3'
),
'level 2' => array(
'level 2.1',
'level 2.2' => array(
'level 2.2.1',
'level 2.2.2',
)
)
);

$level = 0;
$space = "";

function treeFuncRecursive($tree, $level, $space){
foreach ($tree as $key => $value) {
if(is_array($value)){
echo $space.$key."<br>";
$space = $space."&nbsp;&nbsp;";
$level++;
treeFuncRecursive($value, $level, $space);
$level--;
$space = substr($space, 0, -strlen($space));
}else{
echo $space.$value."<br>";
}
}
}
treeFuncRecursive($tree, $level, $space);
}


public function declensionFunc($nums){
$str = "";
// 1,101,201
$a = "Программист";
// 2,3,4,102,103,104,202,203,204,
$b = "Программиста";
// 0,5,6,7,8,9,10,11,12,13...-100,105,106...200,
$c = "Программистов";

foreach ($nums as $value) {
$lastNum = $value % 10;
if ($lastNum == 1) {
$str = $a;
}elseif($lastNum == 2 || $lastNum == 3 || $lastNum == 4){
$str = $b;
}else{
$str = $c;
}
echo $value." ".$str."<br>";
}
}


public function fibonacci($num){

$result2 = $num+$num;
echo "<b>1:</b> ".$num." + ".$num." = ".$result2."<br>";
$result1 = $num;

for ($i=2; $i < 31; $i++) {
$result = $result1 + $result2;
echo "<b>".$i.":</b>  ".$result1." + ".$result2." = ".$result."<br>";
$result1 = $result2;
$result2 = $result;
}

}


private function getPdo(){
$config = [
'host' => 'localhost',
'unix_socket' => '/usr/local/mysql/run/mysqld.sock',
'user' => 'root',
'password' => 'root',
'db'  => 'qsoft',
];

extract($config);

try {
$ERRMODE = [
PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
];
$pdo = new PDO(
'mysql:host='.$host.';dbname='.$db.';unix_socket='.$unix_socket,
$user,
$password,
$ERRMODE
);
// echo 'Подключение удалось:<br>';
return $pdo;
} catch (\PDOException $e) {
echo 'Подключение не удалось: ' . $e->getMessage();
return false;
}
}


public function getMysql(){

$pdo = $this->getPdo();

$sql = "SELECT * FROM cities";
$stmt = $pdo->prepare( $sql );
$stmt->execute();
$result = $stmt->fetchall(\PDO::FETCH_ASSOC);
echo "<b>Все города:</b><br>";
foreach ($result as $value) {
echo $value['id']." ".$value['name']."<br>";
}

// Москва - c7bfa602a4
// Севастополь - 3bcf3d1e9b
$id_city = "3bcf3d1e9b";

$sql = "SELECT companies.name, cities.name AS city_name, offices.name AS office_name FROM companies INNER JOIN (cities, offices) ON companies.id=offices.id_company AND offices.id_city='".$id_city."' AND cities.id='".$id_city."'";
$stmt = $pdo->prepare( $sql );
$stmt->execute();
$result = $stmt->fetchall(\PDO::FETCH_ASSOC);


echo "<b>Выборка всех имен компаний в одном городе по айди города :</b><br>";
foreach ($result as $value) {
echo "`".$value['name']."` <b>".$value['city_name']."</b>, ".$value['office_name']."<br>";
}

}



/*
private function insert($tbl_name, $data){
$pdo = $this->getPdo();
$fields = implode(", ", array_keys($data) );
$values = "('".implode("', '", array_values($data) )."')";
$sql = "INSERT INTO ".$tbl_name." (".$fields.") VALUES ".$values;
$stmt = $pdo->prepare( $sql );
return $stmt->execute();
}

private function hash($name){
$algo = "md5";
$salt = rand(1, 1000000);

$hash = $salt.$name;
$hash = hash($algo, $hash);
$hash = substr($hash, -10);
return $hash;
}


public function insertDemo(){
$name = "ул.Речная, 11";
$id = $this->hash($name);
$id_city = "3bcf3d1e9b";
$id_company = "9511091d59";

$data = array(
"id" => $id,
"name" => $name,
"id_city" => $id_city,
"id_company" => $id_company
);
$tbl_name = "offices";
$this->insert($tbl_name, $data);
}
*/

}


$QSOFT = new QSOFT();

echo "<hr><hr>";
$QSOFT->treeFunc();
echo "<hr><hr>";
$nums = [1, 2, 55, -5];
$QSOFT->declensionFunc($nums);
echo "<hr><hr>";


$num = 1;
$QSOFT->fibonacci($num);
echo "<hr><hr>";


// $QSOFT->insertDemo();
$QSOFT->getMysql();

?>



<hr><hr>
<form name="qsoftForm">
<input type="text" name="digit1"> +
<input type="text" name="digit2"> =
<span id="resQsoftForm"></span><br>
<input type="submit" value="Посчитать">
</form>
<hr><hr>

<script type="text/javascript">
"use strict";

class QSOFT{

constructor(){
this.qsoftForm = document.forms.qsoftForm;
this.resQsoftForm = document.getElementById('resQsoftForm');

this.submitQsoftFormFuncWrapper = this.submitQsoftFormFunc.bind(this);
this.qsoftForm.addEventListener("submit", this.submitQsoftFormFuncWrapper);
};

submitQsoftFormFunc(){
event.stopPropagation();
event.preventDefault();

let digit1 = Number(event.target.elements.digit1.value);
let digit2 = Number(event.target.elements.digit2.value);
let result;

if(	(digit1 != "" && digit2 != "") && (!isNaN(digit1) && !isNaN(digit2)) ){
result = digit1+digit2;
}else{
result = "";
}
this.resQsoftForm.innerHTML = result;

};

}

function ready(){
new QSOFT();
}
window.addEventListener("load", ready);

</script>




</body>
</html>