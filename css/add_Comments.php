<?php
require 'auth.php';
if (isset($_POST["text"]) && isset($_POST["goods_id"]) && isset($_POST["client_id"])) {
    include "connect.php";
    if (!$conn) {
      die("Ошибка: " . mysqli_connect_error());
    }
    check_post();
    $text = mysqli_real_escape_string($conn, $_POST["text"]);
    $goods_id = mysqli_real_escape_string($conn, $_POST["goods_id"]);
    $client_id = mysqli_real_escape_string($conn,$_POST["client_id"]);
    $date = date("Y-m-d");

    $sql = "INSERT INTO comments (customer_text, goods_id, client_id, comment_date) VALUES ('" . $text . "', '" . $goods_id . "', '" . $client_id . "', '" . $date . "')";

    if(mysqli_query($conn, $sql)){
        header("Location: Comments.php");
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
            <h2 class="py-4 text-center">Додати коментар</h2>
            <div class="mb-3">
                <label for="1" class="form-label">Text</label>
                <textarea name="text" type="text" class="form-control" id="1" required></textarea>
            </div>
            <div class="mb-3">
                <label for="2" class="form-label">Goods id</label>
                <input name="goods_id" type="text" class="form-control" id="2" required>
            </div>
            <div class="mb-3">
                <label for="3" class="form-label">Client id</label>
                <input name="client_id" type="text" class="form-control" id="3" required>
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