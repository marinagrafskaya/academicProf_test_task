<?php
include '../connect/db.php';// Подключение к базе данных

$score = $_POST["score"]; 
$id_user = $_POST["id_user"]; 
$id_test = $_POST["id_test"]; 


$sql = "UPDATE results SET scores='$score', date_of_completion=NOW(), status='Пройден' WHERE id_user = $id_user AND id_test = $id_test";
$result = $db->query($sql);

if ($result) {
    $response = true;
} else {
    $response = false;
}

echo json_encode($response);

?>