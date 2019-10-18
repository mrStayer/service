<?php 
	require_once '../php/db.php';

	$data = $_POST;
	// print_r($data);
	if ( isset($data['do_login']) )
	{
		$stmt = $pdo->prepare('SELECT * FROM users WHERE login =:login');
		$stmt->execute(array('login' => $data['login']));
		$user = $stmt->fetchAll()[0];
		
		if ( is_array($user) )
		{
			// echo MD5($data['password']).' '.$user['password'];
			//логин существует
			if ( (trim(MD5($data['password'])) ==  trim($user['password'])) )
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
		
	}
?>


<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Авторизация">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Страница входа | Signin Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/lib/bootstrap-4/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/media/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
  
   <form action="/auth/index.php" method="POST" class="form-signin">
	  <div class="text-center mb-4">
			<img class="mb-4" src="/media/images/icons/keys_security_private_lock.png" alt="" width="72" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
			<?php
				if ( ! empty($errors) )	{
					//выводим ошибки авторизации
					echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div>';
				}
				?>
	  </div>
	  <div class="form-label-group">
		  <label for="inputLogin" class="sr-only">Логин</label>
		  <input type="login" id="inputLogin" name="login" class="form-control" placeholder="Логин" value="<?php echo @$data['login']; ?>" required="" autofocus="">
	  </div>
	  <div class="form-label-group">
		  <label for="inputPassword" class="sr-only">Пароль</label>
		  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Пароль" value="<?php echo @$data['password']; ?>" required="">
	  </div>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Запомнить меня
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="do_login" type="submit">Войти</button>
      <p class="mt-5 mb-3 text-muted">© 2017-2018</p>
    </form>
	
  
</body></html>