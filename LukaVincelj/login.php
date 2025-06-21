<?php
session_start();
include 'connect.php';

$poruka = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'] ?? '';
    $lozinka = $_POST['lozinka'] ?? '';

    $stmt = $conn->prepare("SELECT id, korisnicko_ime, lozinka, razina FROM korisnici WHERE korisnicko_ime = ?");
    $stmt->bind_param("s", $korisnicko_ime);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $korime, $hashirana_lozinka, $razina);
        $stmt->fetch();

        if (password_verify($lozinka, $hashirana_lozinka)) {
            $_SESSION['korisnicko_ime'] = $korime;
            $_SESSION['razina'] = $razina;

            if ($razina === 1) {
                header("Location: administrator.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $poruka = "❌ Neispravna lozinka.";
        }
    } else {
        $poruka = "❌ Korisnik ne postoji. <a href='registracija.php'>Registriraj se ovdje</a>.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <title>Prijava</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
  <h1>L'OBS</h1>
  <nav>
    <ul>
      <li><a href="index.php">Početna</a></li>
      <li><a href="registracija.php">Registracija</a></li>
    </ul>
  </nav>
</header>

<main class="form-container">
  <h2>Prijava</h2>

  <?php if (!empty($poruka)): ?>
    <p class="error"><?php echo $poruka; ?></p>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <div class="form-group">
      <label for="korisnicko_ime">Korisničko ime:</label>
      <input type="text" name="korisnicko_ime" id="korisnicko_ime" required />
    </div>

    <div class="form-group">
      <label for="lozinka">Lozinka:</label>
      <input type="password" name="lozinka" id="lozinka" required />
    </div>

    <input type="submit" value="Prijavi se" />
  </form>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>
