<?php
session_start();
include 'connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM vijesti WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <title><?php echo $article ? htmlspecialchars($article['naslov']) : "Članak nije pronađen"; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
<header>
  <h1>L'OBS</h1>
  <nav>
    <ul>
      <li><a href="index.php">Početna</a></li>
      <li><a href="kategorija.php?kategorija=Politics">Politics</a></li>
      <li><a href="kategorija.php?kategorija=Real Estate">Real Estate</a></li>
      <?php if (isset($_SESSION['razina']) && $_SESSION['razina'] == 1): ?>
        <li><a href="administrator.php">Administracija</a></li>
        <li><a href="unos.php">Dodaj vijest</a></li>
      <?php endif; ?>
      <?php if (isset($_SESSION['korisnicko_ime'])): ?>
        <li><a href="logout.php">Odjava (<?php echo htmlspecialchars($_SESSION['korisnicko_ime']); ?>)</a></li>
      <?php else: ?>
        <li><a href="login.php">Prijava</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main class="article-container">
  <?php if ($article): ?>
    <h2 class="article-title"><?php echo htmlspecialchars($article['naslov']); ?></h2>
    <img src="img/<?php echo htmlspecialchars($article['slika']); ?>" alt="Slika članka" class="article-image" />
    <div class="article-date-banner">
      Objavljeno: <?php echo date('d.m.Y H:i', strtotime($article['datum'])); ?> | Kategorija: <?php echo htmlspecialchars($article['kategorija']); ?>
    </div>
    <p class="article-lead"><?php echo htmlspecialchars($article['sazetak']); ?></p>
    <p><?php echo nl2br(htmlspecialchars($article['tekst'])); ?></p>
  <?php else: ?>
    <h2>Članak nije pronađen</h2>
    <p>Traženi članak ne postoji ili je uklonjen.</p>
  <?php endif; ?>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>
