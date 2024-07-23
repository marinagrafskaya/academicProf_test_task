<?php
session_start();
if ($_SESSION['user']['auth'] != true) {
    header("Location:  ../index.php");
}

// Подключение к базе данных
include '../connect/db.php';

// Получение ID теста из URL-параметра
$id_test = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_test) {
    // Запрос на получение вопросов теста
    $sql = "SELECT * FROM questions WHERE id_test = :id_test";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_test', $id_test);
    $stmt->execute();

    // Вывод списка вопросов
    echo "<h2>Вопросы теста</h2>";
    echo "<ol>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>";
        echo "<strong>{$row['text_questions']}</strong>"; // Текст вопроса

        // Вывод вариантов ответа
        $sql_answers = "SELECT * FROM answers WHERE id_question = :id_question";
        $stmt_answers = $db->prepare($sql_answers);
        $stmt_answers->bindParam(':id_question', $row['id_questions']);
        $stmt_answers->execute();

        echo "<ul>";
        while ($answer_row = $stmt_answers->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>{$answer_row['text_answer']}";
            if ($answer_row['number_of_points'] != 0) {
                echo "<span> *</span></li>";
            }
        }
        echo "</ul>";


        echo "</li>";
    }

    echo "</ol>";

} else {
    // Ошибка: ID теста не найден
    echo "Ошибка: ID теста не задан.";
}

?>