<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$errors = [];

$name = htmlspecialchars(trim($_POST["name"] ?? ""));
$ticketCount = htmlspecialchars(trim($_POST["ticketCount"] ?? ""));
$movie = htmlspecialchars(trim($_POST["movie"] ?? ""));
$date = htmlspecialchars(trim($_POST["date"] ?? ""));
$seatType = htmlspecialchars(trim($_POST["seatType"] ?? ""));
$extras = $_POST["extras"] ?? [];
$comments = htmlspecialchars(trim($_POST["comments"] ?? ""));

if (empty($name)) {
    $errors[] = "Имя не может быть пустым";
}

if (empty($ticketCount)) {
    $errors[] = "Выберите количество билетов";
} elseif (!is_numeric($ticketCount) || $ticketCount < 1 || $ticketCount > 5) {
    $errors[] = "Некорректное количество билетов";
}

if (empty($movie)) {
    $errors[] = "Выберите фильм";
}

if (empty($date)) {
    $errors[] = "Выберите дату сеанса";
}

if (empty($seatType)) {
    $errors[] = "Выберите тип места";
}

if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    header("Location: http://localhost:8082/index.php");
    ob_end_flush();
    exit();
}

$_SESSION["form_data"] = [
    "name" => $name,
    "ticketCount" => $ticketCount,
    "movie" => $movie,
    "date" => $date,
    "seatType" => $seatType,
    "extras" => $extras,
    "comments" => $comments
];

$timestamp = date("Y-m-d H:i:s");
$extrasString = !empty($extras) ? implode(", ", $extras) : "";
$line = $timestamp . ";" . $name . ";" . $ticketCount . ";" . $movie . ";" . $date . ";" . $seatType . ";" . $extrasString . ";" . $comments . "\n";

file_put_contents("data.txt", $line, FILE_APPEND);

header("Location: http://localhost:8082/index.php");
ob_end_flush();
exit();
?>