<?php
require './php/db.php';
session_start();
$login = 'root';
$stmt = $pdo->prepare('SELECT * FROM users WHERE login = :login');
$stmt->execute(array('login' => $login));

while($row = $stmt->fetch(PDO::FETCH_LAZY))
{
//	echo $row['login'].' - '.$row['password']."<br>";
}

$pw   = password_hash('password', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('UPDATE Users SET password=:password WHERE id=1');
$stmt->execute(array( 'password' => $pw ));

	echo $pw."<br>";
?>

