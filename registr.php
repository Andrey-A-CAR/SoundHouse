<?php
//require_once 'db.php';
//$login = $_POST['login'];
//$email = $_POST['email'];
//$pass = $_POST['pass'];
//$repPas = $_POST['repeatpass'];

//if (empty($login) || empty($pass) || empty($repPas) || empty($email)) {
//	echo "Введіть усі дані!";
//} else if ($pass != $repPas) {
//	echo "Паролі не співпадають";
//} else {
//	$sql = "INSERT INTO `users` (login, password, email) VALUES ('$login', '$pass', '$email')";
//	if ($conn->query($sql) === true) {
//		header("Location: index.html");
//	} else {
//		echo "" . $conn->error;
//	}
//}
session_start();
require_once 'db.php';

$login = $_POST['login'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$repeatpass = $_POST['repeatpass'];

if (empty($login) || empty($email) || empty($pass) || empty($repeatpass)) {
	echo "Усі поля обов'язкові!";
	exit;
}

if ($pass !== $repeatpass) {
	echo "Паролі не співпадають!";
	exit;
}

$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (login, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $login, $hashed_pass, $email);

if ($stmt->execute()) {
	$user_id = $conn->insert_id;
	$_SESSION['user_id'] = $user_id;
	$_SESSION['user'] = $email;
	$_SESSION['login'] = $login;
	header("Location: user.php");
} else {
	echo "Помилка реєстрації: " . $conn->error;
}
