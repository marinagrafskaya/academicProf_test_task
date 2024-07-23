<?php
session_start();
include '../connect/db.php';// Подключение к базе данных
if ($_SESSION['user']['auth'] != true) {
    header("Location:  ../index.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Результаты</title>
    <link rel="shortcut icon" href="images/icon.png" type="imabe/png" />
    <link rel="stylesheet" href="../style/style.css" />
    <link rel="stylesheet" href="../style/media.css" />
</head>

<body>
    <?php include "templates/header.php"; ?>
    <main>
        <div class="container">
            <h2>Результаты</h2>
            <div class="wrapper">
                <table id="results">
                    <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th>Email</th>
                            <th>Название теста</th>
                            <th>Количество баллов</th>
                            <th>Дата прохождение</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `results`";
                        $result = $db->query($sql);
                        $result = $result->fetchAll();
                        if (count($result) > 0) {
                            foreach ($result as $row) {
                                $id_user = $row["id_user"];
                                $id_test = $row["id_test"];
                                $scores = $row["scores"];
                                $date_of_completion = $row["date_of_completion"];
                                $status = $row["status"];
                                $userQuery = "SELECT name, login FROM users WHERE id_user = :id_user";
                                $userStatement = $db->prepare($userQuery); 
                                $userStatement->execute([':id_user' => $id_user]);
                                $userResult = $userStatement->fetch(PDO::FETCH_ASSOC);

                                if ($userResult) {
                                    $userName = $userResult["name"];
                                    $userEmail = $userResult["login"];
                                } else {
                                    $userName = "Неизвестный пользователь";
                                    $userEmail = "Неизвестный email";
                                }
                                $testQuery = "SELECT name_test FROM tests WHERE id_test = :id_test";
                                $testStatement = $db->prepare($testQuery);
                                $testStatement->execute([':id_test' => $id_test]);
                                $testResult = $testStatement->fetch(PDO::FETCH_ASSOC);

                                if ($testResult) {
                                    $testName = $testResult["name_test"];
                                } else {
                                    $testName = "Неизвестный тест";
                                }
                                echo "
                            <tr>
                                <td data-label='Пользователь'>
                                    $userName
                                </td>
                                <td data-label='Email'>$userEmail</td>
                                <td data-label='Название теста'>$testName</td>
                                <td data-label='Количество баллов'>$scores</td>
                                <td data-label='Дата прохождение'>$date_of_completion</td>
                                <td data-label='Статус'>$status</td>
                            </tr>
                        ";
                            }
                        } else {
                            echo "Результатов нет";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php include "templates/footer.html"; ?>

</body>

</html>