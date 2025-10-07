

if ($_POST) {
    $errors = array();
    
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $ticketCount = isset($_POST["ticketCount"]) ? intval($_POST["ticketCount"]) : 1;
    $movie = isset($_POST["movie"]) ? trim($_POST["movie"]) : "";
    $date = isset($_POST["date"]) ? trim($_POST["date"]) : "";
    $seatType = isset($_POST["seatType"]) ? trim($_POST["seatType"]) : "";
    $comments = isset($_POST["comments"]) ? trim($_POST["comments"]) : "";
    $extras = isset($_POST["extras"]) ? $_POST["extras"] : array();

    if (empty($name)) $errors[] = "Введите имя";
    if ($ticketCount < 1 || $ticketCount > 10) $errors[] = "Билетов должно быть 1-10";
    if (empty($movie)) $errors[] = "Выберите фильм";
    if (empty($date)) $errors[] = "Выберите дату";
    if (empty($seatType)) $errors[] = "Выберите место";

    if ($errors) {
        $_SESSION["errors"] = $errors;
        header("Location: index.php");
        exit;
    }

    $_SESSION["form_data"] = array(
        "name" => $name,
        "ticketCount" => $ticketCount,
        "movie" => $movie,
        "date" => $date,
        "seatType" => $seatType,
        "comments" => $comments,
        "extras" => $extras
    );

    $line = date("Y-m-d H:i:s") . ";" . $name . ";" . $ticketCount . ";" . $movie . ";" . $date . ";" . $seatType . ";" . implode(",", $extras) . ";" . $comments . "\n";
    file_put_contents("data.txt", $line, FILE_APPEND);

    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
