<?php
require 'auth.php';
if(isset($_GET["id"]))
{
    include "connect.php";
    if (!$conn) {
      die("Ошибка: " . mysqli_connect_error());
    }
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $sql = "DELETE FROM Orders WHERE order_id  = '$id'";
    if(mysqli_query($conn, $sql)){     
        header("Location: Orders.php");
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
    mysqli_close($conn);    
}
header("Location: Orders.php");
?>