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
  <title>Тесты</title>
  <link rel="shortcut icon" href="images/icon.png" type="imabe/png" />
  <link rel="stylesheet" href="../style/style.css" />
  <link rel="stylesheet" href="../style/media.css" />
</head>

<body>
  <?php include "templates/header.php"; ?>
  <main>
    <div class="container">
      <div class="wrapper">
      <div class="message message-admin-test">
          <?php
          if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']); // Удаляем сообщение из сессии после отображения
          }
          ?>
        </div>
        <div class="table-users-wrapper">
          <h2 class="search-title">Поиcк пользователя<div class="help applic-help"
              data-tooltip="Для получения конкретного пользоватьля воcпользуйтеcь поиcком. Предварительно выбрав поле для поиcка">
              <img class="icon-admin" src="../images/message-3-svgrepo-com.svg">
            </div>
          </h2>
          <div class="search">
            <div class="border-input">
              <input class="input input-users-search delete" type="text"
                placeholder="Введите информацию о пользователе">
            </div>
          </div>
          <div class="filter">
            <div>
              <div class="checkbox">
                <input type="checkbox" checked id="nameFilter" class="checkbox-input" />
                <label for="nameFilter" class="checkbox-label"></label>
              </div>
              <span>По названию теста</span>
            </div>
            <div>
              <div class="checkbox">
                <input type="checkbox" id="timeFilter" class="checkbox-input" />
                <label for="timeFilter" class="checkbox-label"></label>
              </div>
              <span>По времени прохождения</span>
            </div>
            <div>
              <div class="checkbox">
                <input type="checkbox" id="questionCountFilter" class="checkbox-input" />
                <label for="questionCountFilter" class="checkbox-label"></label>
              </div>
              <span>По количеству вопросов</span>
            </div>
            <div>
              <div class="checkbox">
                <input type="checkbox" id="minScoreFilter" class="checkbox-input" />
                <label for="minScoreFilter" class="checkbox-label"></label>
              </div>
              <span>По мин. баллу</span>
            </div>
            <div>
              <div class="icon-admin table_update">
                <img src="../images/rotate-right-svgrepo-com.svg">
              </div>
              <span>Обновить таблицу</span>
            </div>
            <div>
              <a href="test.php" class="btn icon-admin">
                +
              </a>
              <span>Добавить тест</span>
            </div>
            <div>
              <img class="icon-admin" src="../images/message-3-svgrepo-com.svg">
              <span>
                Для сортировки данных по столбцу нажмите на его заголовок
              </span>
            </div>
          </div>
          <table class="table-users">
            <thead>
              <tr class="table-header">
                <td class="header__item"><a id="action" class="filter__link">Дейcтвия</a></td>
                <td class="header__item"><a id="name" class="filter__link" href="#">Название
                    теста</a></td>
                <td class="header__item"><a id="time" class="filter__link filter__link--number" href="#">Время на
                    прохождение</a></td>
                <td class="header__item"><a id="question" class="filter__link filter__link--number" href="#">Количество
                    вопросов </a></td>
                <td class="header__item"><a id="score" class="filter__link filter__link--number" href="#">Мин. балл</a>
                </td>
              </tr>
            </thead>
            <tbody class="table-content">
              <?php
              $sql = "SELECT * FROM tests";
              $result = $db->query($sql);
              $result = $result->fetchAll();
              if (count($result) > 0) {
                foreach ($result as $row) {
                  $id = $row["id_test"];
                  $nametest = $row["name_test"];
                  $time = $row["time"];
                  $time /= 60;
                  $numberquestions = $row["number_questions"];
                  $minimumscore = $row["minimum_score"];
                  $link = $row["link"];
                  echo "<tr class='table-row'>";
                  echo "<td class='table-data' aria-label='Дейcтвия' class='table-data-action'>";
                  echo "<a class='btn-action' href='edit.php?id=$id'>Редактировать</a>";
                  echo "<a class='btn-action' href='../actions/delete_test.php?id=$id'>Удалить тест</a>"; 
                  echo "<span class='btn-action' onclick='modal(\"$link\",$id)'>Отправить тест</span>";
                  echo "<a class='btn-action' href='add_questions.php?id=$id'>Добавить вопросы</a>";
                  echo "<a class='btn-action' href='print.php?id=$id'>Просмотр и печать</a>";
                  echo "<a class='btn-action' href='delete_questions.php?id=$id'>Удалить вопрос</a>";
                  echo "</td>";
                  echo "<td class='table-data table-data-search-name' aria-label='Название теста'>$nametest</td>";
                  echo "<td class='table-data table-data-search-time' aria-label='Время на прохождение'>$time</td>";
                  echo "<td class='table-data table-data-search-question' aria-label='Количество вопросов'>$numberquestions</td>";
                  echo "<td class='table-data table-data-search-e-score' aria-label='Мин. балл'>$minimumscore</td>";
                  echo "</tr>";
                }
              } else {
                echo "Тестов нет";
              }

              ?>
            </tbody>
          </table>
        </div>

        <div id="confirmaction" class="modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">Отправить тест</h3>
                <a href="javascript:closeconfirmaction()" title="Закрыть" class="close">×</a>
              </div>
              <div class="modal-body">
                <label>Email</label>
                <div class="border-input"><input type="email" name="email"></div>

                <div class="btn btn-user">OK</div>
                <p class="message-modal none"></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </main>

  <?php include "templates/footer.html"; ?>

  <script src="../js/jquery/jquery.min.js"></script>
  <script src="../js/sort.js"></script>
  <script src="../js/filter.js"></script>
  <script src="../js/test-send.js"></script>

</body>

</html>