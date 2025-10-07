<?php
session_start();

if (['REQUEST_METHOD'] === 'POST') {
    \ = array();
    
    // Получаем и очищаем данные
    \ = htmlspecialchars(trim(\['name'] ?? ''));
    \ = intval(\['ticketCount'] ?? 1);
    \ = htmlspecialchars(trim(\['movie'] ?? ''));
    \ = htmlspecialchars(trim(\['date'] ?? ''));
    \ = htmlspecialchars(trim(\['seatType'] ?? ''));
    \ = htmlspecialchars(trim(\['comments'] ?? ''));
    \ = \['extras'] ?? array();

    // Валидация
    if (empty(\)) {
        \[] = "Имя не может быть пустым";
    }
    
    if (\ < 1 || \ > 10) {
        \[] = "Количество билетов должно быть от 1 до 10";
    }
    
    if (empty(\)) {
        \[] = "Выберите фильм";
    }
    
    if (empty(\)) {
        \[] = "Выберите дату сеанса";
    }
    
    if (empty(\)) {
        \[] = "Выберите тип места";
    }

    // Если есть ошибки - сохраняем в сессию и перенаправляем
    if (!empty(\)) {
        \['errors'] = \;
        header("Location: index.php");
        exit();
    }

    // Сохраняем данные в сессию
    \['form_data'] = array(
        'name' => \,
        'ticketCount' => \,
        'movie' => \,
        'date' => \,
        'seatType' => \,
        'comments' => \,
        'extras' => \
    );

    // Сохраняем в файл
    \ = date('Y-m-d H:i:s') . ";" . \ . ";" . \ . ";" . \ . ";" . \ . ";" . \ . ";" . implode(',', \) . ";" . \ . "\n";
    file_put_contents("data.txt", \, FILE_APPEND);

    // Перенаправляем на главную
    header("Location: index.php");
    exit();
} else {
    // Если не POST запрос - на главную
    header("Location: index.php");
    exit();
}
?>
