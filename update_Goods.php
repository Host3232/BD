<?php
require 'auth.php';
include "connect.php";
if (!$conn) {
    die("Ошибка: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<?php
// если запрос GET
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]))
{
    $userid = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "SELECT * FROM Goods WHERE id = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            foreach($result as $row){
                var_dump($row);
                $username = $row["name"];
                $usertname = $row["price"];
                $usernum = $row["description"];
                $usernnum = $row["availability"];
            }
            echo "<h3>Обновлення коментарів</h3>
                <form method='post'>
                    <input type='hidden' name='id' value='$userid' />
                    <p>Ім'я:
                    <input type='text' name='name' value='$username' /></p>
                    <p>Ціна:
                    <input type='text' name='price' value='$usertname' /></p>
                    <p>Опис:</p>
                    <textarea type='number' name='description' rows=10 cols=30>$usernum</textarea>
                    <p>Наявність:
                    <input type='text' name='availability' value='$usernnum' /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Товар не знайдено </div>";
        }
        mysqli_free_result($result);
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
}
elseif (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"]) && isset($_POST["availability"])) {
    check_post();
    $userid = mysqli_real_escape_string($conn, $_POST["id"]);
    $username = mysqli_real_escape_string($conn, $_POST["name"]);
    $usertname = mysqli_real_escape_string($conn, $_POST["price"]);
    $usernum = mysqli_real_escape_string($conn, $_POST["description"]);
    $usernnum = mysqli_real_escape_string($conn,$_POST["availability"]);
      
    $sql = "UPDATE Goods SET name = '$username', price = '$usertname', description = '$usernum', availability = '$usernnum' WHERE id = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        header("Location: Goods.php");
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
}
else{
    echo "Некорректные данные";
}
mysqli_close($conn);
?>
</body>
</html>