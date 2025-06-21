<?php
session_start();
if (!isset($_SESSION['razina']) || $_SESSION['razina'] != 1) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <title>Dodaj vijest</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
<header>
  <h1>L'OBS</h1>
  <nav>
    <ul>
      <li><a href="index.php">Početna</a></li>
      <li><a href="administrator.php">Administracija</a></li>
      <li><a href="logout.php">Odjava (<?php echo htmlspecialchars($_SESSION['korisnicko_ime']); ?>)</a></li>
    </ul>
  </nav>
</header>

<main class="form-container">
  <h2>Dodaj novu vijest</h2>
  <form action="skripta.php" method="POST" enctype="multipart/form-data">
    <label for="title">Naslov:</label>
    <input type="text" name="title" id="title" required>

    <label for="about">Sažetak:</label>
    <textarea name="about" id="about" rows="3" required></textarea>

    <label for="content">Tekst vijesti:</label>
    <textarea name="content" id="content" rows="8" required></textarea>

    <label for="category">Kategorija:</label>
    <select name="category" id="category" required>
      <option value="">-- Odaberi kategoriju --</option>
      <option value="Politics">Politics</option>
      <option value="Real Estate">Real Estate</option>
    </select>

    <label for="pphoto">Slika:</label>
    <input type="file" name="pphoto" id="pphoto" accept="image/*" required>

    <div class="checkbox-group">
      <input type="checkbox" name="archive" id="archive">
      <label for="archive">Arhiviraj vijest</label>
    </div>

    <div class="form-buttons">
      <input type="submit" value="Objavi vijest">
      <input type="reset" value="Poništi">
    </div>
  </form>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>
