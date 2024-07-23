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
    <title>Редактирование</title>
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
            <form class="test-add-form" action="../actions/edit_test.php" method="POST">
                <?php
                $sql = "SELECT * FROM `tests` WHERE `id_test`= $id_test";
                $result = $db->query($sql);
                $result = $result->fetchAll();
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        $nametest = $row["name_test"];
                        $time = $row["time"];
                        $time /= 60;
                        $minimumscore = $row["minimum_score"];
                        echo "<input type='hidden' name='id' value='$id_test'>";
                        echo "<h2>Редактирование теста - $nametest</h2>";
                        echo "<label>Название теста</label>
                        <div class='border-input'><input type='text' name='name_test' value='$nametest'></div>
                        <label>Время на прохождение (м)</label>
                        <div class='border-input'><input type='number' name='time' value='$time'></div>
                        <label>Мин. балл</label>
                        <div class='border-input'><input type='number' name='minimum_score' value='$minimumscore'></div>";
                    }
                }
                ?>
                    <div><input type="submit" class="btn login-button" value="ОК"></div>
            </form>
        </div>

    </main>

    <?php include "templates/footer.html"; ?>
    <script src="..\js\addQuestion.js"></script>
</body>

</html>

