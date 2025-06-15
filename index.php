<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sound House</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #1e1b2f;
			font-family: 'Segoe UI', sans-serif;
			color: #f9e79f;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: flex-start;
			min-height: 100vh;
			padding-top: 60px;
		}

		h1 {
			color: #d5bfff;
			margin-bottom: 40px;
		}

		.auth-buttons {
			display: flex;
			gap: 20px;
			margin-bottom: 30px;
		}

		.auth-buttons button {
			padding: 12px 25px;
			background-color: #6a0dad;
			border: none;
			border-radius: 8px;
			color: #f8d9ff;
			font-size: 16px;
			cursor: pointer;
			transition: background 0.3s;
		}

		.auth-buttons button:hover {
			background-color: #8a5be2;
		}

		form {
			display: none;
			flex-direction: column;
			gap: 12px;
			background-color: #2c2340;
			padding: 20px 30px;
			border-radius: 10px;
			border: 1px solid #8a5be2;
			width: 300px;
			margin-bottom: 40px;
		}

		form input {
			padding: 10px;
			border: none;
			border-radius: 5px;
			outline: none;
		}

		form button {
			padding: 10px;
			background-color: #8a5be2;
			border: none;
			border-radius: 5px;
			color: white;
			cursor: pointer;
		}

		form button:hover {
			background-color: #a273ff;
		}
	</style>
</head>

<body>

	<h1>Sound House</h1>

	<div class="auth-buttons">
		<button onclick="showForm('register')">Реєстрація</button>
		<button onclick="showForm('login')">Вхід</button>
	</div>

	<form id="registerForm" action="registr.php" method="post">
		<input type="text" name="login" placeholder="Логін" required />
		<input type="email" name="email" placeholder="Email" required />
		<input type="password" name="pass" placeholder="Пароль" required />
		<input type="password" name="repeatpass" placeholder="Повторіть пароль" required />
		<button type="submit">Зареєструватись</button>
	</form>

	<form id="loginForm" action="login.php" method="post">
		<input type="email" name="email" placeholder="Email" required />
		<input type="password" name="pass" placeholder="Пароль" required />
		<button type="submit">Увійти</button>
	</form>

	<script>
		function showForm(formType) {
			const registerForm = document.getElementById('registerForm');
			const loginForm = document.getElementById('loginForm');

			if (formType === 'register') {
				registerForm.style.display = 'flex';
				loginForm.style.display = 'none';
			} else if (formType === 'login') {
				loginForm.style.display = 'flex';
				registerForm.style.display = 'none';
			}
		}
	</script>

</body>

</html>