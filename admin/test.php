<?php
session_start();
if ($_SESSION['user']['auth'] != true) {
  header("Location:  ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Добавить тест</title>
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
      <form class="test-add-form" action="../actions/add_test.php" method="POST">
        <label>Название теста</label>
        <div class="border-input"><input type="text" name="name_test"></div>
        <label>Время на прохождение (м)</label>
        <div class="border-input"><input type="number" name="time"></div>
        <label>Мин. балл</label>
        <div class="border-input"><input type="number" name="minimum_score"></div>


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