<?php
require 'auth.php';
if (isset($_POST["client_name"]) && isset($_POST["client_email"]) && isset($_POST["client_address"])) {
    include "connect.php";
    if (!$conn) {
      die("Ошибка: " . mysqli_connect_error());
    }
    check_post();
    $name    = mysqli_real_escape_string($conn, $_POST["client_name"]);
    $email   = mysqli_real_escape_string($conn, $_POST["client_email"]);
    $address = mysqli_real_escape_string($conn, $_POST["client_address"]);
    $sql = "INSERT INTO client (client_name, client_email, client_address) VALUES ('" . $name . "', '" . $email . "', '" . $address . "')";
    if(mysqli_query($conn, $sql)){
        header("Location: /index.php");
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
            <h2 class="py-4 text-center">Додати клієнта</h2>
            <div class="mb-3">
                <label for="1" class="form-label">Client name</label>
                <input name="client_name" type="text" class="form-control" id="1" required>
            </div>
            <div class="mb-3">
                <label for="2" class="form-label">Client email</label>
                <input name="client_email" type="email" class="form-control" id="2" required>
            </div>
            <div class="mb-3">
                <label for="3" class="form-label">Client address</label>
                <input name="client_address" type="text" class="form-control" id="3" required>
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