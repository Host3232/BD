<?php
require 'auth.php';
if (isset($_POST["client_id"]) && isset($_POST["goods_id"])) {
    include "connect.php";
    if (!$conn) {
      die("Ошибка: " . mysqli_connect_error());
    }
    check_post();
    $client_id = mysqli_real_escape_string($conn, $_POST["client_id"]);
    $goods_id  = mysqli_real_escape_string($conn, $_POST["goods_id"]);
    
    $price = mysqli_query($conn, "SELECT price FROM goods WHERE id = " . $goods_id);
    $price = $price->fetch_all();
    
    if ($price) {
        $price = $price[0][0];
    } else {
        exit("Ошибка: Товара с айди $goods_id нету!");
    }
    $dt = date("Y:m:d H:i:s");

    $sql = "INSERT INTO orders (client_id, order_date, goods_id, price) VALUES ('" . $client_id . "', '" . $dt . "', '" . $goods_id . "', '" . $price . "')";
    if(mysqli_query($conn, $sql)){
        header("Location: Orders.php");
    } else{
        echo "Ошибка: " . mysqli_error($conn);
    }
    mysqli_close($conn);
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/base.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h2 class="py-4 text-center">Додати замовлення</h2>
            <div class="mb-3">
                <label for="1" class="form-label">Client id</label>
                <input name="client_id" type="text" class="form-control" id="1" required>
            </div>
            <div class="mb-3">
                <label for="2" class="form-label">Goods id</label>
                <input name="goods_id" type="text" class="form-control" id="2" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Додати</button>
            </div>
        </form>
    </div>
</body>
</html>

<?
}
?>