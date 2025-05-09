<?php
session_start();

if (!isset($_SESSION["user"])) {
  die("Accès interdit.");
}

$id = $_SESSION["user"]["id"];
$newLogin = $_POST["login"] ?? "";
$newEmail = $_POST["email"] ?? "";

$dataFile = "../data/utilisateurs.json";
$users = json_decode(file_get_contents($dataFile), true);

foreach ($users as &$u) {
  if ($u["id"] == $id) {
    $u["login"] = $newLogin;
    $u["email"] = $newEmail;
    $_SESSION["user"]["login"] = $newLogin;
    $_SESSION["user"]["email"] = $newEmail;
    break;
  }
}

file_put_contents($dataFile, json_encode($users, JSON_PRETTY_PRINT));
header("Location: ../page6.php?success=1");
exit;
?>
