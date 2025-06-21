<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['razina']) || $_SESSION['razina'] != 1) {
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $naslov = $_POST['title'];
  $sazetak = $_POST['about'];
  $tekst = $_POST['content'];
  $kategorija = $_POST['category'];
  $arhiva = isset($_POST['archive']) ? 1 : 0;

  if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] === 0) {
    $slika = basename($_FILES['pphoto']['name']);
    $target = 'img/' . $slika;

    if (move_uploaded_file($_FILES['pphoto']['tmp_name'], $target)) {
      $stmt = $conn->prepare("INSERT INTO vijesti (naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssi", $naslov, $sazetak, $tekst, $slika, $kategorija, $arhiva);
      $stmt->execute();
      $stmt->close();

      header("Location: index.php");
      exit;
    } else {
      echo "Greška pri učitavanju slike.";
    }
  } else {
    echo "Datoteka nije prenesena.";
  }
} else {
  echo "Neispravan zahtjev.";
}
?>
