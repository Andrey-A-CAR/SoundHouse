<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	http_response_code(403);
	echo 'Not authorized';
	exit;
}

require_once 'db.php';

$userId = $_SESSION['user_id'];
$name = trim($_POST['name'] ?? '');

if ($name === '') {
	http_response_code(400);
	echo 'Назва пуста';
	exit;
}

$stmt = $pdo->prepare("INSERT INTO playlists (user_id, name) VALUES (?, ?)");
$stmt->execute([$userId, $name]);

echo 'OK';
