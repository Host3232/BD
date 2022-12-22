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
    $sql = "SELECT * FROM Client WHERE client_id_serial = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            foreach($result as $row){
                $username = $row["client_name"];
                $usertname = $row["client_email"];
                $usernum = $row["client_address"];
            }
            echo "<h3>Обновлення пасажиру</h3>
                <form method='post'>
                    <input type='hidden' name='client_id_serial' value='$userid' />
                    <p>Ім'я:
                    <input type='text' name='client_name' value='$username' /></p>
                    <p>Email:
                    <input type='email' name='client_email' value='$usertname' /></p>
                    <p>Адреса:
                    <input type='text' name='client_address' value='$usernum' /></p>
                    <input type='submit' value='Сохранить'>
            </form>";
        }
        else{
            echo "<div>Клієнт не знайден</div>";
        }
        mysqli_free_result($result);
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
}
elseif (isset($_POST["client_id_serial"]) && isset($_POST["client_name"]) && isset($_POST["client_email"]) && isset($_POST["client_address"])) {
    check_post();
    $userid = mysqli_real_escape_string($conn, $_POST["client_id_serial"]);
    $username = mysqli_real_escape_string($conn, $_POST["client_name"]);
    $usertname = mysqli_real_escape_string($conn, $_POST["client_email"]);
    $usernum = mysqli_real_escape_string($conn, $_POST["client_address"]);
      
    $sql = "UPDATE Client SET client_name = '$username', client_email = '$usertname', client_address = '$usernum' WHERE client_id_serial = '$userid'";
    if($result = mysqli_query($conn, $sql)){
        header("Location: index.php");
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