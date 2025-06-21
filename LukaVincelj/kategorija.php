<?php
session_start();
include 'connect.php';

$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';

$stmt = $conn->prepare("SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = ? ORDER BY datum DESC");
$stmt->bind_param("s", $kategorija);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <title><?php echo htmlspecialchars($kategorija); ?> - Vijesti</title>
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

<main>
  <section class="category">
    <h2><?php echo htmlspecialchars($kategorija); ?></h2>
    <div class="articles">
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <article>
            <a href="clanak.php?id=<?php echo $row['id']; ?>">
              <img src="img/<?php echo htmlspecialchars($row['slika']); ?>" alt="Slika članka">
              <h3><?php echo htmlspecialchars($row['naslov']); ?></h3>
            </a>
          </article>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center;">Nema dostupnih vijesti u ovoj kategoriji.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
