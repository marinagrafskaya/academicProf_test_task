<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>РАЗДЕЛ 1. ОСНОВНЫЕ ПОНЯТИЯ И СТАНДАРТИЗАЦИЯ ТРЕБОВАНИЙ К ПРОГРАММНОМУ ОБЕСПЕЧЕНИЮ</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include '../connect/db.php';// Подключение к базе данных
    $id_test = isset($_GET['code']) ? $_GET['code'] : null;

    $sqlTest = "SELECT * FROM tests WHERE code = '$id_test'";
    $test = $db->query($sqlTest)->fetch(PDO::FETCH_ASSOC);

    // Проверка, найден ли тест
    if (!$test) {
        http_response_code(404); // Возвращаем код 404 (Not Found)
        echo json_encode(['error' => 'Тест с указанным кодом не найден']);
        exit;
    }

    // Запрос на получение вопросов
    $sqlQuestions = "SELECT * FROM questions WHERE id_test = " . $test['id_test'];
    $questions = $db->query($sqlQuestions)->fetchAll(PDO::FETCH_ASSOC);

    // Запрос на получение ответов
    $sqlAnswers = "SELECT * FROM answers WHERE id_question IN (SELECT id_questions FROM questions WHERE id_test = " . $test['id_test'] . ")";
    $answers = $db->query($sqlAnswers)->fetchAll(PDO::FETCH_ASSOC);


    echo "<input type='hidden' class='inputTest' name='testDatatest[test]' value='" . json_encode($test) . "'>";
    echo "<input type='hidden' class='questionsTest' name='testData[questions]' value='" . json_encode($questions) . "'>";
    echo "<input type='hidden' class='answersTest' name='testData[answers]' value='" . json_encode($answers) . "'>";
    echo "<input type='hidden' class='IdUser' value='" . $_SESSION["user"]["id"] . "'>";
    ?>
    <main class="main">
        <h1>РАЗДЕЛ 1. ОСНОВНЫЕ ПОНЯТИЯ И СТАНДАРТИЗАЦИЯ ТРЕБОВАНИЙ К ПРОГРАММНОМУ ОБЕСПЕЧЕНИЮ</h1>

        <div>
            <div class="quiz__head">
                <div class="head__content" id="head"></div>
            </div>
            <div class="quiz__body">
                <div class="buttons">
                    <div class="buttons__content" id="buttons">

                    </div>
                </div>
            </div>
        </div>

        <div class="quiz__footer">
            <div class="footer__content" id="pages">0 / 0</div>
            <div class="timer"></div>
            <div class="btn finish">Завершить тест</div>
        </div>

    </main>
    <script src="js/test.js"></script>
</body>

</html>