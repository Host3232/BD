<?php
require 'auth.php';
if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["description"])) {
    include "connect.php";
    if (!$conn) {
      die("Ошибка: " . mysqli_connect_error());
    }
    check_post();
    $name         = mysqli_real_escape_string($conn, $_POST["name"]);
    $price        = mysqli_real_escape_string($conn, $_POST["price"]);
    $description  = mysqli_real_escape_string($conn, $_POST["description"]);
    $availability = "unavailable";
    if (isset($_POST["availibility"])) {
        $availability = "available";
    }
    $sql = "INSERT INTO goods (name, price, description, availability) VALUES ('" . $name . "', '" . $price . "', '" . $description . "', '" . $availability . "')";
    if(mysqli_query($conn, $sql)){
        header("Location: Goods.php");
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
            <h2 class="py-4 text-center">Додати товар</h2>
            <div class="mb-3">
                <label for="1" class="form-label">Goods name</label>
                <input name="name" type="text" class="form-control" id="1" required>
            </div>
            <div class="mb-3">
                <label for="2" class="form-label">Goods price</label>
                <input name="price" type="text" class="form-control" id="2" required>
            </div>
            <div class="mb-3">
                <label for="3" class="form-label">Description</label>
                <input name="description" type="text" class="form-control" id="3" required>
            </div>
            <div class="mb-3 form-check">
                <input name="availibility" type="checkbox" class="form-check-input" id="4">
                <label class="form-check-label" for="4">Availability</label>
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