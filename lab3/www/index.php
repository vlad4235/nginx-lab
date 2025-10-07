
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Кинотеатр</title>
    <style>
        body { font-family: Arial; max-width: 800px; margin: 50px auto; padding: 20px; }
        .data { background: #f0f0f0; padding: 15px; margin: 20px 0; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Кинотеатр - Главная</h1>
    
    <div>
        <a href="form.html">Заполнить форму</a> | 
        <a href="view.php">Все заказы</a>
    </div>

    <?php 
    if(isset($_SESSION["errors"])) {
        echo "<div class=\"error\">";
        echo "<h3>Ошибки:</h3>";
        echo "<ul>";
        foreach($_SESSION["errors"] as $error) {
            echo "<li>" . $error . "</li>";
        }
        echo "</ul>";
        echo "</div>";
        unset($_SESSION["errors"]);
    }

    if(isset($_SESSION["form_data"])) {
        echo "<div class=\"data\">";
        echo "<h3>Последний заказ:</h3>";
        echo "<p>Имя: " . $_SESSION["form_data"]["name"] . "</p>";
        echo "<p>Билетов: " . $_SESSION["form_data"]["ticketCount"] . "</p>";
        echo "<p>Фильм: " . $_SESSION["form_data"]["movie"] . "</p>";
        echo "<p>Дата: " . $_SESSION["form_data"]["date"] . "</p>";
        echo "<p>Место: " . $_SESSION["form_data"]["seatType"] . "</p>";
        echo "</div>";
        unset($_SESSION["form_data"]);
    } else {
        echo "<p>Заказов пока нет. Заполните форму!</p>";
    }
    ?>

    <p><a href="phpinfo.php">PHP информация</a></p>
</body>
</html>
