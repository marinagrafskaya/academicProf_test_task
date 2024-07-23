<?php
session_start();
if ($_SESSION['user']['auth'] != true) {
    header("Location:  ../index.php");
  }

// Подключение к базе данных
include '../connect/db.php';

// Получение ID теста из URL-параметра
$id_test = isset($_GET['id']) ? $_GET['id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Удаление вопросов</title>
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
                $sql = "SELECT * FROM `tests` WHERE `id_test`= $id_test";
                $result = $db->query($sql);
                $result = $result->fetchAll();
                foreach ($result as $row) {
                    $nametest = $row["name_test"];
                    echo "<h2>Вопросы теста - $nametest</h2>";
                }
                ?>
            </div>
            <div class="delete-questions">
                <?php
                $sql = "SELECT * FROM `questions` WHERE `id_test` =  $id_test";
                $result = $db->query($sql);
                $result = $result->fetchAll();
                foreach ($result as $row) {
                    $id = $row['id_questions'];
                    $text = $row['text_questions'];
                   echo "<form class='form-delete-question' action='../actions/delete_questions_test.php' method='POST'>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='id_test' value='$id_test'>
                    <div class='body-answer-test'>
                       $text
                    </div>
                    <div><input type='submit' class='btn' value='Удалить'></div>
                </form>";
                }
                ?>
               
            </div>
        </div>

    </main>

    <?php include "templates/footer.html"; ?>
    <script src="..\js\addQuestion.js"></script>
</body>

</html>