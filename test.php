<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: aut.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Пройти тест</title>
    <link rel="shortcut icon" href="images/icon.png" type="imabe/png" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/media.css" />
</head>

<body>
    <?php include "templates/header.php"; ?>
    <main>
        <section id="test">
            <div class="container">

                <div class="description">
                    <div class="img"><img src="images/female-student-passing-exam-checking-answers_74855-14022.jpg">
                    </div>
                    <div>
                        <div class="text">
                            <p>Ваш тест ждет вас!🚀</p>

                            <p>Вы получили ссылку, которая откроет доступ к тесту.</p>

                            <p>Что нужно сделать:</p>

                            <p>1. Скопируйте ссылку.</p>
                            <p>2. Вставьте ее в поле ввода.</p>
                            <p>3. Нажмите кнопку "Начать".</p>

                            Удачи! 👍

                        </div>
                        <form action="" method="GET">
                            <label>Ссылка на тест:</label>
                            <div class="border-input"><input type="text" name="link"></div>
                            <div><input type="submit" class="btn" value="Начать"></div>
                        </form>

                        <script>
                            const form = document.querySelector('form');

                            form.addEventListener('submit', function (event) {
                                event.preventDefault(); // Предотвратить стандартную отправку формы

                                const linkInput = document.querySelector('input[name="link"]');
                                const link = "http://" + linkInput.value;

                                if (link) {
                                    window.location.href = link; // Перенаправление на введенный URL
                                } else {
                                    alert("Введите ссылку на тест.");
                                }
                            });
                        </script>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <?php include "templates/footer.html"; ?>

</body>

</html>