<?php
session_start();
include '../connect/db.php';

$to = clear_data($_POST["email"]);
$link = clear_data($_POST["link"]);
$id_test = $_POST["id"];

$subject = "Пройти тест на АкадемияПроф";
$headers = [
    "From" => "m.grafskaya507@mail.ru",
    "Content-type" => "text/html; charset=utf-8"
];


$message = "
        <html>
        <body>
        <center>
            Пройдите тест по этой ссылке: $link
        </center>
        </body>
        </html>
        ";
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

$email = $to;
$sql = "SELECT id_user FROM users WHERE `login` = :email";
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    $userId = $user['id_user'];
    $sql = "INSERT INTO `results`(`id_user`, `id_test`) VALUES ($userId,$id_test)";
    $result = $db->query($sql);
} else {
    $response = false;
}


echo json_encode($response);

?>