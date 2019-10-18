<?php // ******* Импорт файла 2017 в БД `service` **********
require_once '../lib/simple-xlsx/simplexlsx.class.php'; 
require_once 'db.php';
require_once 'lib.php';

// Файл xlsx
$xlsx = new SimpleXLSX( '..//data/2017.xlsx');

$a_tbl = Array();
$A_unit = Array();
$A_staff = Array();

// Первый лист
$sheet = $xlsx->rows(0);
 $tmp='';
  
// Импорт данных в массив
for ($i=0, $imax=10; $i < $imax; $i++) 
{
	$a_tbl[$i] = Array();
	for ($j=0, $jmax=16; $j < $jmax; $j++)
	{
		$a_tbl[$i][$j] = $sheet[$i][$j];
	}
} 

// Импорт Типов, Моделей, Подразделений, Сотрудников для послед обработки
$a_techType  = Array();
$a_techModel = Array();
$a_staff 	 = Array();
$a_union     = Array();

$stmt = $pdo->query('SELECT * FROM `TechType`');
$a_techType = $stmt->fetchAll(PDO::FETCH_NUM);

$stmt = $pdo->query('SELECT * FROM `TechModel`');
$a_techModel = $stmt->fetchAll(PDO::FETCH_NUM);

$stmt = $pdo->query('SELECT * FROM `Staff`');
$a_staff = 	$stmt->fetchAll(PDO::FETCH_NUM);

$stmt = $pdo->query('SELECT * FROM `UnitMVD`');
$a_union = 	$stmt->fetchAll(PDO::FETCH_NUM);

#  printA($a_staff, "Список сотрудников");
#  printA($a_union, "Список подразделений");
#  printA($a_techType, "Тип техники");
#  printA($a_techModel, "Модельный ряд");
 
// Формирование запросов к б.д
$a_sql_tech = Array();

$sqlTechRep = 'INSERT INTO `TechRep` (`id`, `num`, `techType`, `techModel`, `serialNum`, `inventNum`, `unit`, `worker`, `admissionDate`, `appeal`, `repHistory`, `receiveDate`, `receiver` )';
$sqlTechRep = 'VALUES( :id, :num, :techType, :techModel, :serialNum, :inventNum, :unit, :worker, :appeal, :repHistory, :receiveDate, :receiver )';
//$stmt = $pdo->prepare($sqlTechRep);
$a_values = Array();

// Заменяем значения Типов техники на индексы
val2key($a_tbl, $a_techType, 1, 0);
// Заменяем значения Модели на индексы
val2key($a_tbl, $a_techModel, 2, 0);
// Заменяем значения Подразделений на индексы
val2key($a_tbl, $a_union, 5, 0);
// Заменяем значения Сотрудников на индексы
val2key($a_tbl, $a_staff, 6, 0);

for ($i=1, $imax=10; $i < $imax; $i++)
{
	$a_values[$i] = Array(
		'id' 		=> $a_tbl[$i][0], 
		'num' 		=> $a_tbl[$i][1], 
		'techType'  => $a_tbl[$i][2], 
		'techModel' => $a_tbl[$i][3], 
		'serialNum' => $a_tbl[$i][4],
		'inventNum' => $a_tbl[$i][5],
		'unit'		=> $a_tbl[$i][6],
		'worker'	=> $a_tbl[$i][7],
		'admissionDate' => $a_tbl[$i][8]
		);	
}
$a_sql = Array(); $sql ='';
for ($i=1;$imax=10;$i++)
{	$sql = 'INSERT INTO `TechRep` '
	foreach($a_tbl[$i] as $key=>$val)
	{
		
	}
}

//******************     Проверка массива          **********************
echo "<hr><pre>";
	print_r($a_techModel);
	print_r($a_tbl);
  // print_r($A_staff); print_r($A_unit);
// SELECT (@n:=@n+1) as num, name FROM `TechModel` WHERE `TechTypePid` =10
// in_array('yes', array_map('strtolower', $array))
echo "</pre><hr>";


 function inMultiArray( $needle, $target)
 {
	$result = false;
	foreach ($target as $row)
	{
		if ( trim(mb_strtolower($row[1], 'utf8')) === trim($needle) )
		{
			return true;
		}else{
		//	echo trim(mb_strtolower($row[1], 'utf8')) .' '. trim($needle);
		}		
	}
	return $result;
 }
 
 function mb_in_array(array $_hayStack,$_needle) {
    foreach ($_hayStack as $value) {
		if(trim(mb_strtolower($value, 'utf8')) === trim($_needle)) {
            return true;
        }else{
			echo mb_strtolower($value, 'utf8').'-----'.$_needle."<br>";
		}
    }
return false;   
}


function val2key(&$values, &$keys, $i_val, $i_key)
{
	for($i=1, $imax=count($values); $i<$imax; $i++)
	{
		for($j=0, $jmax=count($keys);$j<$jmax; $j++)
		{
			echo trim(mb_strtolower($values[$i][$i_val], 'utf8'))." === ".trim(mb_strtolower($keys[$j][1], 'utf8'))."$j <br>";
			if ( trim(mb_strtolower($values[$i][$i_val], 'utf8')) === trim(mb_strtolower($keys[$j][1], 'utf8')) )
			{
				echo $keys[$j][$i_key];
				$values[$i][$i_val] = $keys[$j][$i_key];
				break;
			}
		}
	}
}
function pdoSet(&$values, $source = array())
{
	$set = '';
	
	foreach ($values as $field)
	{
		$set .= "`".str_replace("`", "``", $field)."`"."=:$field, ";
	}
	return $set;
}
?>

