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
	
require_once './php/db.php'; 
 
 
 ?>
<?php include('./template/header.php'); ?>
 <main role="main">
	<div class="jumbotron">
 <?
 
 
 
 $stmt = $pdo->prepare('SELECT rep.id as `N`,
						type.name as `Тип техники`, 
						model.name as `Модель`, 
						serialNum as `Серийный номер`, 
						inventNum as `Инвентарный номер`, 
						unit.name as `Подразделение`,
						staff.fio as `Сдал ФИО`,
						admissionDate as `Дата приемки`,
						appeal as `Причина`,
						status as `Статус`,
						receiveDate as `Дата получения`,
						staff2.fio as `Получил ФИО`
						
						FROM TechRep as rep 
						LEFT JOIN TechType as type ON rep.techType = type.id
						LEFT JOIN TechModel as model ON rep.techModel = model.id
						LEFT JOIN UnitMvd as unit ON rep.unit = unit.id
						LEFT JOIN Staff as staff ON rep.whoGave = staff.id
						LEFT JOIN Staff as staff2 ON rep.whoTook = staff2.id
						');
 $stmt->execute();
 
 
  $rows = $stmt->fetchAll();
   
 echo "<table class='table table-sm table-bordered'>"; 
  for ($i = -1; $i < count($rows); $i++) {
	  echo "<tr>";
	  
      if ($i == -1) {
		  foreach ($rows[0] as $key => $val ){
			 echo "<th class='text-center'>".$key."</th>";
		  }
	  }else{
		    foreach ($rows[$i] as $key => $val ){
			 if ($key === 'N'){ 
				echo "<td><a href=\"$val\"><small>".($i+1)."</small></a></td>"; 
			 }else{
				 if ( ( strpos( $key , 'Дата' ) !== false ) and strlen( $val ) > 6)  { $val = date( 'd.m.Y', strtotime($val ) ); }  
				 echo "<td><small>".$val."</td>";
			 }
		  }
	  }
	  
	  echo "</tr>";
  }	  
 echo "</table><pre>";
 
?>
</div>
</div>
<?php include('./template/footer.php');