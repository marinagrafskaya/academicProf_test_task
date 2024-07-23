<?php
session_start();

try {
    include '../connect/db.php';// Подключение к базе данных

    $id_test = isset($_GET['id']) ? $_GET['id'] : null;

    $sql = "DELETE FROM `tests` WHERE `id_test` = $id_test";
    $result = $db->query($sql);

    // Устанавливаем сообщение об успехе в сессию
    $_SESSION['message'] = "<p style='color:green;'>Тест удален!</p>";
    header("Location: ../admin/index.php"); // Перенаправляем на исходную страницу 
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
    header("Location: ../admin/index.php"); // Перенаправляем на исходную страницу 
    exit;
}
?>
