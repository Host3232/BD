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
    $sql = "SELECT * FROM Comments WHERE comments_id = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            foreach($result as $row){
                $username = $row["customer_text"];
                $usertname = $row["goods_id"];
                $usernum = $row["client_id"];
                $usernnum = $row["comment_date"];
            }
            echo "<h3>Обновлення коментарів</h3>
                <form method='post'>
                    <input type='hidden' name='comments_id' value='$userid' />
                    <p>Текст клієнта :</p>
                    <textarea name='customer_text' rows=10 cols=30>$username</textarea>
                    <p>ID клієнта :
                    <input type='text' name='client_id' value='$usernum' /></p>
                    <p>Id товару :
                    <input type='text' name='goods_id' value='$usertname' /></p>
                    <p>Дата коментарю:
                    <input type='text' name='comment_date' value='$usernnum' /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Опис не знайдено </div>";
        }
        mysqli_free_result($result);
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
}
elseif (isset($_POST["comments_id"]) && isset($_POST["customer_text"]) && isset($_POST["goods_id"]) && isset($_POST["client_id"])) {
    check_post();
    $userid = mysqli_real_escape_string($conn, $_POST["comments_id"]);
    $username = mysqli_real_escape_string($conn, $_POST["customer_text"]);
    $usertname = mysqli_real_escape_string($conn, $_POST["goods_id"]);
    $usernum = mysqli_real_escape_string($conn, $_POST["client_id"]);
    $usernnum = mysqli_real_escape_string($conn,$_POST["comment_date"]);
      
    $sql = "UPDATE Comments SET customer_text = '$username', goods_id = '$usertname', client_id = '$usernum',comment_date = '$usernnum' WHERE comments_id = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        header("Location: Comments.php");
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