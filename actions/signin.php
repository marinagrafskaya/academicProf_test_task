<?php 
session_start(); // Запуск сессии
include '../connect/db.php';// Подключение к базе данных

$login = $_POST["login"]; // Присвоить переменной $login значение из поля login
$password = $_POST["password"]; // Присвоить переменной $password значение из поля $password

$error_fields = []; // массив ошибок

if ($login === '') {  
    $error_fields[] = 'login';      // если какое-то из полей пустое записать их названия в массив
}

if ($password === '') {
    $error_fields[] = 'password';
}

if(!empty($error_fields)) {   // елли массив ошибок не пустой 

    $response = [    
        "status" => false,
        "message" => "Проверьте правильность полей",
        "fields" => $error_fields

    ];

    echo json_encode($response);  // перевести ответ в формат json
    
    die(); // остановить программу
}

$sql = "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password';";
$result = $db -> query($sql);
$result = $result -> fetchAll();
if($result) { // если переменная $result не пустая и такой пользователь существует , то   
    if($result[0]["role"]==='admin') { // если id пользователя 1 , то 
        $response = [
            "role" => "admin",
            "status" => true,
        ]; 
        $_SESSION["user"] = [
            "auth" => true,
        ];
    // переходим на страницу администратора
    } else { // иначе 
      //  записать значения записи в ассоциативный массив $_SESSION['user']
      foreach($result as $row) {
        $_SESSION["user"] = [
            "id" => $row['id_user'],
            "auth" => true,
        ];
    };
    $response = [
        "status" => true, 
    ];
   
}
echo json_encode($response);
}
else {
        $error_fields[] = 'login';      
        $error_fields[] = 'password';
    $response = [
        "status" => false,
        "message" => "Неверный логин или пароль",
        "fields" => $error_fields
    ];

    echo json_encode($response);
}
?>