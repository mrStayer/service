<?php
require_once __DIR__ . '/lib/simple-xlsx/simplexlsx.class.php'; 

$con = mysql_connect('localhost','root','');
mysql_select_db('service', $con);

// Файл xlsx
$xlsx = new SimpleXLSX(__DIR__ . '/data/2017.xlsx');

$A_unit = Array(); $A_staff = Array();

// подключение через PDO
$pdo = new PDO("mysql:host=localhost;dbname=service", 'root', '');

// Список всех подразделений
$unitListSQL = 'SELECT * FROM `UnitMVD`';
$unitListRaw = mysql_query($unitListSQL);
$A_unitList	 = Array();
while ($line = mysql_fetch_row( $unitListRaw )){
	$A_unitList[] = $line;
}

// echo "<pre>"; print_r($A_unitList); echo "</pre>";

// Первый лист
$sheet = $xlsx->rows(0);
 $i=0; $j=0;
 $tmp='';
  
foreach ($sheet as $row) {
  if ($i>0 and $i < 2703) //2703
  { 
	  $sotr = trim( mb_strtolower( $row[6], 'utf8' ) );
	  $podr = trim( mb_strtolower( $row[5], 'utf8' ) );
	   
	  if (! mb_in_array($A_staff, $sotr)) 
	  {
		$A_staff[] = $row[6];
		// if (! inMultiArray($podr, $A_unit)){	
			$A_unit[] = Array( $row[6], $row[5] );
		// }else{
			//$A_unit[]=  $row[6], $row[5];
		// }
	  }
   }
   $i++; $j++;
}
/*
for ($i=0, $l = count($unit); $i<$l; $i++)
{
  $sql = "INSERT INTO `Staff` VALUES(NULL, '".$unit[$i]."')";
	   echo $sql;
	    // $result =  mysql_query($sql) ;
		echo "<br>".mysql_insert_id().' '.mysql_error();
		echo "#$i #$j <hr>";
}
//*/
echo "<hr><pre>";
  print_r($A_staff); print_r($A_unit);
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
?>

