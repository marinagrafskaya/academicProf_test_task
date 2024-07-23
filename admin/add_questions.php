<?php
session_start();
if ($_SESSION['user']['auth'] != true) {
    header("Location:  ../index.php");
  }
// Подключение к базе данных 
include '../connect/db.php';// Подключение к базе данных

// Получение ID теста из URL-параметра
$id_test = isset($_GET['id']) ? $_GET['id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Добавление вопросов</title>
    <link rel="shortcut icon" href="images/icon.png" type="imabe/png" />
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/media.css" />
</head>

<body>
    <?php include "templates/header.php"; ?>
    <main>

        <div class="container">

            <div class="message message-admin-test">
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']); // Удаляем сообщение из сессии после отображения
                }
                ?>
            </div>
            <form class="test-add-form" action="../actions/add_questions.php" method="POST">
                <?php
                $sql = "SELECT * FROM `tests` WHERE `id_test`= $id_test";
                $result = $db->query($sql);
                $result = $result->fetchAll();
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        $nametest = $row["name_test"];
                        echo "<input type='hidden' name='id' value='$id_test'>";
                        echo "<h2>Добавление вопросов в тест - $nametest</h2>";
                    }
                }
                ?>
                <div class="answer-test">
                    <div class="title-answer-test">
                        <div>Вопросы</div>
                        <div class="btn" onclick="addQuestion()">+</div>
                    </div>

                    <div class="body-answer-test">
                        <label>Текст вопроса</label>
                        <div class="border-input"><input type="text" name="question[]"></div>

                        <div>Ответы</div>
                        <div class="response-group">
                            <div class="response-item-group">
                                <label>Ответ 1</label>
                                <div class="border-input"><input type="text" name="answer_1[]"></div>
                            </div>
                            <div class="response-item-group">
                                <label>Количество баллов за Ответ 1</label>
                                <div class="border-input"><input type="number" name="answer_1_score[]"></div>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-item-group">
                                <label>Ответ 2</label>
                                <div class="border-input"><input type="text" name="answer_2[]"></div>
                            </div>
                            <div class="response-item-group">
                                <label>Количество баллов за Ответ 2</label>
                                <div class="border-input"><input type="number" name="answer_2_score[]"></div>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-item-group">
                                <label>Ответ 3</label>
                                <div class="border-input"><input type="text" name="answer_3[]"></div>
                            </div>
                            <div class="response-item-group">
                                <label>Количество баллов за Ответ 3</label>
                                <div class="border-input"><input type="number" name="answer_3_score[]"></div>
                            </div>
                        </div>
                        <div class="response-group">
                            <div class="response-item-group">
                                <label>Ответ 4</label>
                                <div class="border-input"><input type="text" name="answer_4[]"></div>
                            </div>
                            <div class="response-item-group">
                                <label>Количество баллов за Ответ 4</label>
                                <div class="border-input"><input type="number" name="answer_4_score[]"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div><input type="submit" class="btn login-button" value="Добавить"></div>
            </form>
        </div>

    </main>

    <?php include "templates/footer.html"; ?>
    <script src="..\js\addQuestion.js"></script>
</body>

</html>