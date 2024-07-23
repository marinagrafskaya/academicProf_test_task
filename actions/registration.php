<?php
session_start();
include '../connect/db.php';

$to = clear_data($_POST["email"]);
$name = clear_data($_POST["name"]);

$subject = "Пароль для сайта АкадемияПроф";
$headers = [
    "From" => "m.grafskaya507@mail.ru",
    "Content-type" => "text/html; charset=utf-8"
];


$sql = "SELECT * FROM `users` WHERE `login` = '$to'";
$result = $db->query($sql);
$result = $result->fetchAll();
if ($result) { // если переменная $result не пустая и такой пользователь существует , то 
    $message = sending_letter($result);
} else {
    $password = generateRandomPassword();
    $id = generateUniqueID($db);
    $sql = "INSERT INTO users (id_user, name, login, password) VALUES ($id, '$name', '$to', '$password')";
    $result2 = $db->query($sql);
    
    if ($result2) { // Проверяем результат запроса на вставку
        // Получаем данные нового пользователя
        $sql = "SELECT * FROM users WHERE id_user = $id";
        $result3 = $db->query($sql);
    
        if ($result3) { // Проверяем результат запроса на выборку
            $newUser = $result3->fetchAll(); // Получаем данные пользователя
            $message = sending_letter($newUser); // Передаем данные нового пользователя в функцию
        } else {
            // Обработка ошибки запроса
            echo "Ошибка получения данных пользователя";
        }
    } else {
        // Обработка ошибки запроса
        echo "Ошибка вставки пользователя";
    }
}


function sending_letter($result)
{
    foreach ($result as $row) {
        $message = '
            <html>
            <body>
            <center>
            <table border="1" cellpadding="6" cellspacing="0" width="90%" bordercolor="#2c4964">
            <tr>
                <td colspan="2" align="center">
                    <b>Email и пароль для входа в систему</b>
                </td>
            </tr>
            <tr>
                <td><b>ФИО: </b></td>
                <td>' . $row['name'] . '</td>
            </tr>
            <tr>
                <td><b>Email: </b></td>
                <td>' . $row['login'] . '</td>
            </tr>
            <tr>
                <td><b>Пароль: </b></td>
                <td>' . $row['password'] . '</td>
            </tr>
            </table>
            </center>
            </body>
            </html>
        ';
    }
    ;
    return $message;
}

function generateUniqueID($db)
{
    // Определяем длину ID
    $length = 5; 

    // Генерируем случайное число в нужном диапазоне
    $id = rand(pow(10, $length - 1), pow(10, $length) - 1);

    // Проверяем, есть ли уже такой ID в базе данных
    $sql = "SELECT COUNT(*) FROM users WHERE `id_user` = $id";
    $result = $db->query($sql);
    $count = $result->fetchColumn();

    // Если ID уже существует, генерируем новый
    if ($count > 0) {
        return generateUniqueID($db); // Рекурсивно вызываем функцию
    } else {
        return $id;
    }
}

// Функция генерации случайного пароля
function generateRandomPassword()
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    $randomString = '';
    for ($i = 0; $i < 12; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function clear_data($val)
{
    $val = trim($val);
    $val = stripslashes($val);
    $val = htmlspecialchars($val);
    return $val;
}


if (mail($to, $subject, $message, $headers)) {
    $response = true;
}

echo json_encode($response);

?>