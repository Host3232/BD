<?php
require 'auth.php';
if(isset($_GET["id"]))
{
    include "connect.php";
    if (!$conn) {
      die("Ошибка: " . mysqli_connect_error());
    }
    $userid = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "DELETE FROM client WHERE client_id_serial = '$userid'";
    if(mysqli_query($conn, $sql)){     
        header("Location: index.php");
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
    mysqli_close($conn);    
}
header("Location: index.php");
?>