<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Вход в систему</title>
    <link rel="shortcut icon" href="images/icon.png" type="imabe/png" />
    <link rel="stylesheet" href="style/style.css" />
    <link rel="stylesheet" href="style/media.css" />
</head>

<body>
    <?php include "templates/header.php"; ?>

    <main>

        <section id="aut">
            <div class="container">

                <div class="description">
                    <div class="img"><img src="images/tiny-man-sitting-chair-with-laptop-checklist-background_74855-20395.jpg"></div>
                    <div class="text">
                        <p>Готовы бросить вызов своим знаниям? 🧠🚀</p>

                        <p>Начните прохождение тестов уже сегодня!</p>

                        <p>
                            Чтобы получить доступ к тестам, просто введите ваш электронный адрес в поле ниже. Мы
                            вышлем вам уникальный пароль, который позволит проверить свои
                            навыки.
                        </p>

                        <p>Не теряйте времени! Начните проходить тесты и убедитесь в своих силах!</p>
                    </div>
                </div>

                <form class="aut-form">
                    <label>ФИО</label>
                    <div class="border-input"><input type="text" name="name"></div>
                    <label>Email</label>
                    <div class="border-input"><input type="email" name="email"></div>
                    <button class="btn get_password">Получить пароль</button>
                    <label>Пароль</label>
                    <div class="border-input"><input type="password" name="password"></div>
                    <div><input type="submit" class="btn login-button" value="Войти"></div>
                    <p class="message none"></p>
                </form>
            </div>

        </section>


    </main>

    <?php include "templates/footer.html"; ?>

    <script src="js/aut.js"></script>
    <script src="js/get_password.js"></script>

</body>

</html>