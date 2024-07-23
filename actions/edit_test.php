<?php
session_start();

try {
    include '../connect/db.php';// Подключение к базе данных
    $id = $_POST['id'];

    // Запрос на изменение теста 
    $sql_test = "UPDATE `tests` SET `name_test`=:name_test,`time`=:time,`minimum_score`=:minimum_score WHERE `id_test` = $id";

    $stmt_test = $db->prepare($sql_test);

    $name_test = $_POST['name_test'];
    $time = $_POST['time'];
    $time *= 60;
    $minimum_score = $_POST['minimum_score'];

    $stmt_test->bindParam(':name_test', $name_test);
    $stmt_test->bindParam(':time', $time);
    $stmt_test->bindParam(':minimum_score', $minimum_score);


    $stmt_test->execute();


    // Устанавливаем сообщение об успехе в сессию
    $_SESSION['message'] = "<p style='color:green;'>Данные успешно добавлены в базу данных.</p>";
    header("Location: ../admin/edit.php?id=$id"); // Перенаправляем на исходную страницу 
    exit;

} catch (PDOException $e) {
    $error_code = $e->getCode();
    $error_message = $e->getMessage();

    // Извлечение перевода из таблицы error_messages
    $stmt = $db->prepare("SELECT error_message_ru FROM error_messages WHERE error_code = :error_code");
    $stmt->bindParam(':error_code', $error_code);
    $stmt->execute();
    $translation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($translation) {
        // Устанавливаем сообщение об ошибке в сессию
        $_SESSION['message'] = "<p style='color:red;'>Ошибка: " . $translation['error_message_ru'] . "</p>";
    } else {
        $_SESSION['message'] = "<p style='color:red;'>Ошибка: " . $error_message . "</p>";
    }
    header("Location: ../admin/edit.php?id=$id"); // Перенаправляем на исходную страницу 
    exit;
}
?>