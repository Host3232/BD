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
    $sql = "SELECT * FROM Orders WHERE order_id = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            foreach($result as $row){
                $ci = $row["client_id"];
                $username = $row["order_date"];
                $usertname = $row["goods_id"];
                $usernum = $row["price"];
            }
            echo "<h3>Обновлення пасажиру</h3>
                <form method='post'>
                    <input type='hidden' name='order_id' value='$userid' />
                    <p>ІD клієнта :
                    <input type='text' name='client_id' value='$ci' /></p>
                    <p>ІD товару :
                    <input type='text' name='goods_id' value='$usertname' /></p>
                    <p>Дата замовлення:
                    <input type='text' name='order_date' value='$username' /></p>
                    <p>Ціна товару:
                    <input type='number' name='price' value='$usernum' /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Замолвення не знайден</div>";
        }
        mysqli_free_result($result);
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
}
elseif (isset($_POST["order_id"]) && isset($_POST["client_id"]) && isset($_POST["order_date"]) && isset($_POST["goods_id"]) && isset($_POST["price"])) {
    check_post();
    $order_id = mysqli_real_escape_string($conn, $_POST["order_id"]);
    $userid = mysqli_real_escape_string($conn, $_POST["client_id"]);
    $username = mysqli_real_escape_string($conn, $_POST["order_date"]);
    $usertname = mysqli_real_escape_string($conn, $_POST["goods_id"]);
    $usernum = mysqli_real_escape_string($conn, $_POST["price"]);
      
    $sql = "UPDATE Orders SET client_id = '$userid', order_date = '$username', goods_id = '$usertname', price = '$usernum' WHERE order_id = '$order_id'";
    if($result = mysqli_query($conn, $sql)){
        header("Location: Orders.php");
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