<?php
session_start();
include 'connect.php';

$poruka = "";
$uspjesnaRegistracija = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime']);
    $prezime = trim($_POST['prezime']);
    $username = trim($_POST['username']);
    $lozinka = $_POST['lozinka'];
    $lozinkaPonovno = $_POST['lozinkaPonovno'];

    if ($lozinka !== $lozinkaPonovno) {
        $poruka = "❌ Lozinke se ne podudaraju.";
    } else {
        $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);
        $razina = 0;

        $stmt = $conn->prepare("SELECT id FROM korisnici WHERE korisnicko_ime = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $poruka = "❌ Korisničko ime već postoji.";
        } else {
            $stmt = $conn->prepare("INSERT INTO korisnici (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $ime, $prezime, $username, $hashed_password, $razina);
            if ($stmt->execute()) {
                $uspjesnaRegistracija = true;
            } else {
                $poruka = "❌ Greška prilikom registracije.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Registracija</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
  <h1>L'OBS</h1>
  <nav>
    <ul>
      <li><a href="index.php">Početna</a></li>
      <li><a href="login.php">Prijava</a></li>
    </ul>
  </nav>
</header>

<main class="form-container">
  <h2>Registracija korisnika</h2>

  <?php if ($uspjesnaRegistracija): ?>
    <p class="success">✅ Registracija uspješna. <a href="login.php">Prijavite se</a>.</p>
  <?php else: ?>
    <?php if (!empty($poruka)): ?>
      <p class="error"><?php echo htmlspecialchars($poruka); ?></p>
    <?php endif; ?>

    <form method="POST" action="registracija.php">
      <div class="form-group">
        <label for="ime">Ime:</label>
        <input type="text" name="ime" id="ime" required />
      </div>

      <div class="form-group">
        <label for="prezime">Prezime:</label>
        <input type="text" name="prezime" id="prezime" required />
      </div>

      <div class="form-group">
        <label for="username">Korisničko ime:</label>
        <input type="text" name="username" id="username" required />
      </div>

      <div class="form-group">
        <label for="lozinka">Lozinka:</label>
        <input type="password" name="lozinka" id="lozinka" required />
      </div>

      <div class="form-group">
        <label for="lozinkaPonovno">Ponovite lozinku:</label>
        <input type="password" name="lozinkaPonovno" id="lozinkaPonovno" required />
      </div>

      <input type="submit" value="Registriraj se" />
    </form>
  <?php endif; ?>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>
