<?php
//require_once 'db.php';

//$email = $_POST['email'];
//$pass = $_POST['pass'];

//if (empty($email) || empty($pass)) {
//	echo "Введіть усі дані!";
//} else {
//	$sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'";
//	$result = $conn->query($sql);
//	if ($result->num_rows > 0) {
//		header("Location: index.html");
//	} else {
//		echo "пошта або пароль не вірні" . $conn->error;
//	}
//}
session_start();
require_once 'db.php';

$email = $_POST['email'];
$pass = $_POST['pass'];

if (empty($email) || empty($pass)) {
	echo "Заповніть усі поля!";
	exit;
}

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
	if (password_verify($pass, $user['password'])) {
		$_SESSION['user'] = $user['email'];
		$_SESSION['login'] = $user['login'];
		$_SESSION['user_id'] = $user['id'];
		header("Location: user.php");
	} else {
		echo "Невірний пароль!";
	}
} else {
	echo "Користувача не знайдено!";
}
