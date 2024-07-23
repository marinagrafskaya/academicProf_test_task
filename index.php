<?php
session_start();
include 'connect/db.php';// Подключение к базе данных
if (!isset($_SESSION['user'])) {
  header("Location: aut.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Результаты</title>
  <link rel="shortcut icon" href="images/icon.png" type="imabe/png" />
  <link rel="stylesheet" href="style/style.css" />
  <link rel="stylesheet" href="style/media.css" />
</head>

<body>
  <?php include "templates/header.php"; ?>
  <main>
    <section id="results">
      <div class="container">

        <h2>Пройденные тесты</h2>
        <div class="wrapper-results">
          <?php
          $id_user = $_SESSION["user"]["id"];
          $sql = "SELECT * FROM `results` WHERE id_user = $id_user AND status = 'Пройден'";
          $result = $db->query($sql);
          $result = $result->fetchAll();
          if (count($result) > 0) {
            foreach ($result as $row) {
              $scores = $row["scores"];
              $id_test = $row["id_test"];
              $date_of_completion = $row["date_of_completion"];
              $sql_test_name = "SELECT name_test FROM tests WHERE id_test = $id_test";
              $result_test_name = $db->query($sql_test_name);
              $test_name = $result_test_name->fetchColumn(); // Получаем имя теста
              echo "
              <div class='item-test'>
              <label for='answer' class='results-item'>
                <p>$test_name</p>
                <div class='arrow'><img src='images/arrow-right-1-svgrepo-com.png' /></div>
              </label>
              <input type='checkbox' id='answer' />
              <div class='answer'>
                <p>Баллы: $scores</p>
                <p>Дата прохождения: $date_of_completion</p>
              </div>
            </div>";
            }
          } else {
            echo "Нет тестов";
          }
          ;
          ?>

        </div>

      </div>

    </section>

  </main>

  <?php include "templates/footer.html"; ?>

</body>

</html>