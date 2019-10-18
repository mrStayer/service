<?php 
	require_once '../php/db.php';

	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$stmt = $pdo->prepare('SELECT * FROM users WHERE login =:login');
		$stmt->execute(array('login' => $data['login']));
		$user = $stmt->fetchAll()[0];
		
		if ( is_array($user) )
		{
			//логин существует
			if ( password_verify(trim($data['password']), trim($user['password'])) )
			{
				//если пароль совпадает, то нужно авторизовать пользователя
				$_SESSION['logged_user'] = $user;
				header('Location: /');
			}else
			{
				$errors[] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}
		// */
		if ( ! empty($errors) )
		{
			//выводим ошибки авторизации
			echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}
	}
?>


<form action="/auth/index.php" method="POST">
	<strong>Логин</strong>
	<input type="text" name="login" value="<?php echo @$data['login']; ?>"><br/>

	<strong>Пароль</strong>
	<input type="password" name="password" value="<?php echo @$data['password']; ?>"><br/>

	<button type="submit" name="do_login">Войти</button>
</form>