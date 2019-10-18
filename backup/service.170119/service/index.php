<?php
session_start();
if ( isset ($_SESSION['logged_user']) ) 
{
	echo $_SESSION['logged_user']->login;
}
else
{
	header('Location: /auth/');
}
	
require_once __DIR__ . '/lib/simple-xlsx/simplexlsx.class.php'; 
require_once __DIR__ . '/php/db.php'; 
require_once __DIR__ . '/php/lib.php';
	
$a_staff = Array(); // сотрудники
$a_units  = Array(); // подразделения




// файл xlsx
$xlsx = new SimpleXLSX(__DIR__ . '/data/2017.xlsx');

// первый лист
$sheet = $xlsx->rows(1);
echo "<pre>";
$i = $j = 0;
foreach ($sheet as $row) {
	// $html = print_r($row);
	$val = $row[6];
	// Сохраняем в массив только уникальные значения
	if (! in_array(strtolower($val), array_map('strtolower', $a_staff)))
	{
		$a_staff[] 	= $row[6] ;
	}
	
	
	$i++; $j++;
	if ($i > 2701) { break; }
	if ($j > 0 ){ break;}
}
print_r($a_staff);
echo $html;




?>