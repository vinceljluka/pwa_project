<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['razina']) || $_SESSION['razina'] != 1) {
    echo "<p class='error' style='text-align: center;'>⛔ Nemaš pravo pristupa ovoj stranici.</p>";
    exit;
}

$sql_all = "SELECT id, naslov FROM vijesti ORDER BY datum DESC";
$result_all = $conn->query($sql_all);

$article = null;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM vijesti WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $article = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM vijesti WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: administrator.php");
        exit;
    }

    if (isset($_POST['update'])) {
        $naslov = $_POST['naslov'];
        $sazetak = $_POST['sazetak'];
        $tekst = $_POST['tekst'];
        $kategorija = $_POST['kategorija'];
        $arhiva = isset($_POST['arhiva']) ? 1 : 0;

        $stmt = $conn->prepare("UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, kategorija=?, arhiva=? WHERE id=?");
        $stmt->bind_param("ssssii", $naslov, $sazetak, $tekst, $kategorija, $arhiva, $id);
        $stmt->execute();
        header("Location: administrator.php?id=$id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8" />
  <title>Administracija</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
  <h1>L'OBS</h1>
  <nav>
    <ul>
      <li><a href="index.php">Početna</a></li>
      <li><a href="unos.php">Dodaj vijest</a></li>
      <li><a href="logout.php">Odjava (<?php echo htmlspecialchars($_SESSION['korisnicko_ime']); ?>)</a></li>
    </ul>
  </nav>
</header>

<main class="article-container">
  <h2 style="text-align:center;">Administracija vijesti</h2>

  <ul>
    <?php while ($row = $result_all->fetch_assoc()): ?>
      <li><a href="administrator.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['naslov']); ?></a></li>
    <?php endwhile; ?>
  </ul>

  <?php if ($article): ?>
    <form method="POST" class="admin-form">
      <input type="hidden" name="id" value="<?php echo $article['id']; ?>">

      <label for="naslov">Naslov:</label>
      <input type="text" name="naslov" value="<?php echo htmlspecialchars($article['naslov']); ?>" required>

      <label for="sazetak">Sažetak:</label>
      <textarea name="sazetak" rows="2" required><?php echo htmlspecialchars($article['sazetak']); ?></textarea>

      <label for="tekst">Tekst:</label>
      <textarea name="tekst" rows="6" required><?php echo htmlspecialchars($article['tekst']); ?></textarea>

      <label for="kategorija">Kategorija:</label>
      <select name="kategorija" required>
        <option value="Politics" <?php if ($article['kategorija'] === 'Politics') echo 'selected'; ?>>Politics</option>
        <option value="Real Estate" <?php if ($article['kategorija'] === 'Real Estate') echo 'selected'; ?>>Real Estate</option>
      </select>

      <label>
        <input type="checkbox" name="arhiva" <?php if ($article['arhiva']) echo 'checked'; ?> />
        Arhiviraj
      </label>

      <div class="form-buttons">
        <button type="submit" name="update">Ažuriraj</button>
        <button type="submit" name="delete" onclick="return confirm('Jesi li siguran da želiš obrisati ovu vijest?')">Obriši</button>
      </div>
    </form>
  <?php endif; ?>
</main>

<footer>
  <p>Author: Luka Vincelj | Contact: lvincelj@tvz.hr | Year: 2025</p>
</footer>
</body>
</html>

<?php $conn->close(); ?>
