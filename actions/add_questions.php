<?php

session_start();

try {
    include '../connect/db.php';// Подключение к базе данных

    $id_test = $_POST["id"];

    $sql_question = "INSERT INTO questions (id_test, text_questions) 
                 VALUES (:id_test, :text_questions)";

    $stmt_question = $db->prepare($sql_question);

    // Запрос на добавление ответов в таблицу 'answers'
    $sql_answer = "INSERT INTO answers (id_question, text_answer, number_of_points) 
               VALUES (:id_question, :text_answer, :number_of_points)";

    $stmt_answer = $db->prepare($sql_answer);

    // Добавляем вопросы и ответы
    for ($i = 0; $i < count($_POST['question']); $i++) {
        $text_question = $_POST['question'][$i];

        // Добавляем вопрос 
        $stmt_question->bindParam(':id_test', $id_test);
        $stmt_question->bindParam(':text_questions', $text_question);
        $stmt_question->execute();

        // Получаем ID нового вопроса
        $id_question = $db->lastInsertId();

        // Добавляем ответы для текущего вопроса
        for ($j = 1; $j <= 4; $j++) { // 4 варианта ответа
            $answer_text = $_POST['answer_' . $j][$i]; // Текст ответа
            $answer_score = $_POST['answer_' . $j . '_score'][$i]; // Балл за ответ

            // Добавляем ответы
            $stmt_answer->bindParam(':id_question', $id_question);
            $stmt_answer->bindParam(':text_answer', $answer_text);
            $stmt_answer->bindParam(':number_of_points', $answer_score);
            $stmt_answer->execute();
        }
    }

    $sql = "SELECT COUNT(*) AS total_questions FROM questions WHERE id_test = $id_test;";
    $result = $db->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $totalQuestions = $row['total_questions'];

    $sql = "UPDATE `tests` SET `number_questions`='$totalQuestions' WHERE `id_test` = $id_test";
    $result = $db->query($sql);
    

    // Устанавливаем сообщение об успехе в сессию
    $_SESSION['message'] = "<p style='color:green;'>Данные успешно добавлены в базу данных.</p>";
    header("Location: ../admin/add_questions.php?id=$id_test"); // Перенаправляем на исходную страницу 
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
    header("Location: ../admin/add_questions.php?id=$id_test"); // Перенаправляем на исходную страницу 
    exit;
}
?>