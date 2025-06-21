<?php
session_start();
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <title>L'OBS - Naslovna</title>
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
        <li><a href="logout.php">Odjava (<?php echo htmlspecialchars($_SESSION['korisnicko_ime']); ?>)</a></li>
      <?php elseif (isset($_SESSION['korisnicko_ime'])): ?>
        <li><a href="logout.php">Odjava (<?php echo htmlspecialchars($_SESSION['korisnicko_ime']); ?>)</a></li>
      <?php else: ?>
        <li><a href="login.php">Prijava</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main>
  <?php
  $kategorije = ['Politics', 'Real Estate'];

  foreach ($kategorije as $kategorija) {
    echo "<section class=\"category\">";
    echo "<h2>" . htmlspecialchars($kategorija) . "</h2>";
    echo "<div class=\"articles\">";

    $stmt = $conn->prepare("SELECT id, naslov, slika FROM vijesti WHERE arhiva = 0 AND kategorija = ? ORDER BY datum DESC LIMIT 3");
    $stmt->bind_param("s", $kategorija);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      echo "<p>Nema dostupnih vijesti u ovoj kategoriji.</p>";
    } else {
      while ($row = $result->fetch_assoc()) {
        echo "<article>";
        echo "<a href=\"clanak.php?id=" . $row['id'] . "\">";
        echo "<img src=\"img/" . htmlspecialchars($row['slika']) . "\" alt=\"Slika članka\">";
        echo "<h3>" . htmlspecialchars($row['naslov']) . "</h3>";
        echo "</a>";
        echo "</article>";
      }
    }

    echo "</div></section>";
    $stmt->close();
  }
  ?>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>
