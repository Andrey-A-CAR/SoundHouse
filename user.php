<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user'])) {
	header("Location: index.php");
	exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM playlists WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$playlists = [];
while ($row = $result->fetch_assoc()) {
	$playlists[] = $row;
}

$email = $_SESSION['user'];
$login = $_SESSION['login'];
?>

<!DOCTYPE html>
<html lang="uk">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Sound House</title>
	<link rel="stylesheet" href="style.css" />
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
	<header>
		<h1>Sound House</h1>
	</header>

	<div class="content">
		<aside class="sidebar">
			<nav>
				<ul>
					<li>
						<div class="user-menu">
							<a href="javascript:void(0);" onclick="toggleModal()" style="position: relative;">
								<i class="fas fa-user icon"></i>
								<span class="text-accaunt"><?php echo htmlspecialchars($login);
															?></span>
							</a>
							<div id="logoutModal">
								<a href="logout.php" class="btn logout">Вийти</a>
							</div>
						</div>
					</li>
					<li class="playlist-container">
						<a href="javascript:void(0);" onclick="togglePlaylistMenu()">
							<i class="fas fa-headphones icon"></i><span class="text">Мої плейлисти</span>
						</a>

						<div class="playlist-menu" id="playlistMenu">
							<div class="playlist-input-wrapper">
								<input type="text" id="playlistName" placeholder="Назва плейлиста">
								<button onclick="createPlaylist()" class="btn create-playlist">+</button>
							</div>
							<ul id="playlistList" class="playlist-list">
								<?php
								require_once 'db.php'; // підключення до бази
								$userId = $_SESSION['user_id']; // переконайся, що це поле є в сесії

								$stmt = $conn->prepare("SELECT id, name FROM playlists WHERE user_id = ?");
								$stmt->bind_param("i", $userId);
								$stmt->execute();
								$result = $stmt->get_result();
								while ($playlist = $result->fetch_assoc()): ?>
									<li class="playlist-item" data-id="<?= $playlist['id'] ?>">
										<span><i class="fas fa-music"></i> <?= htmlspecialchars($playlist['name']) ?></span>
										<button class="delete-btn" onclick="deletePlaylist(this)">
											<i class="fas fa-trash"></i>
										</button>
									</li>
								<?php endwhile; ?>
							</ul>
						</div>
					</li>
					<li>
						<a href="#"><i class="fas fa-star icon"></i><span class="text">Улюблене</span></a>
					</li>
				</ul>
			</nav>
		</aside>



		<main class="music-section">
			<h2>Наші треки</h2>
			<div class="track-list">
				<div class="track">
					<p class="track-title">
						🎵Teresa & Maria - alyona-alyona / Jerry Heil
					</p>
					<audio controls>
						<source
							src="musics/alyona-alyona-jerry-heil-teresa-maria-(meloua.com).mp3"
							type="audio/mpeg" />
						Ваш браузер не підтримує елемент <code>audio</code>.
					</audio>
				</div>
				<div class="track">
					<p class="track-title">🎵Кайся - Нікіта Кісельов</p>
					<audio controls>
						<source
							src="musics/Кайся - Нікіта Кісельов.mp3"
							type="audio/mpeg" />
						Ваш браузер не підтримує елемент <code>audio</code>.
					</audio>
				</div>
				<div class="track">
					<p class="track-title">🎵Подруга моя - Анна Трінчер</p>
					<audio controls>
						<source
							src="musics/anna-trincher-podruga-moya-(meloua.com).mp3"
							type="audio/mp3" />
						Ваш браузер не підтримує елемент <code>audio</code>.
					</audio>
				</div>
				<div class="track"></div>
			</div>
		</main>
	</div>

	<footer>
		<p>&copy; 2025 Музична Платформа</p>
	</footer>

	<script>
		window.onload = function() {
			const modal = document.getElementById('logoutModal');
			if (modal) modal.style.display = 'none';
		}

		function toggleModal() {
			const modal = document.getElementById('logoutModal');
			if (!modal) return;

			// Отримати поточне значення стилю (враховуючи CSS)
			if (modal.style.display === 'block') {
				modal.style.display = 'none';
			} else {
				modal.style.display = 'block';
			}
		}
		let playlistMenuVisible = false;

		function togglePlaylistMenu() {
			const menu = document.getElementById('playlistMenu');
			playlistMenuVisible = !playlistMenuVisible;
			menu.style.display = playlistMenuVisible ? 'block' : 'none';
		}

		function createPlaylist() {
			const nameInput = document.getElementById('playlistName');
			const name = nameInput.value.trim();
			if (name === '') return;

			fetch('create_playlist.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: `name=${encodeURIComponent(name)}`
				})
				.then(response => {
					if (!response.ok) throw new Error('Не вдалося створити плейлист');
					return response.text();
				})
				.then(data => {
					addPlaylistToUI(name);
					nameInput.value = '';
					togglePlaylistMenu();
				})
				.catch(error => {
					alert(error.message);
				});
		}

		function addPlaylistToUI(name) {
			const list = document.getElementById('playlistList');
			const li = document.createElement('li');
			li.classList.add("playlist-item");
			li.innerHTML = `
		<span><i class="fas fa-music"></i> ${name}</span>
		<button class="delete-btn" onclick="deletePlaylist(this)">
			<i class="fas fa-trash"></i>
		</button>
	`;
			list.appendChild(li);
		}

		function deletePlaylist(button) {
			const li = button.closest("li");
			li.remove();
		}
	</script>


</body>

</html>