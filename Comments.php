<?php require 'auth.php'; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="css/base.css">
</head>
<body>
<div class="container">
    <h2 class="py-4">Список коментарів</h2>
    <table>
        <tr>
            <th><a class="btn btn-primary" href="index.php">Client</a></th>
            <th><a class="btn btn-primary" href="Goods.php">Goods</a></th>
            <th><a class="btn btn-primary" href="Orders.php">Orders</a></th>
            <?php if (!$is_auth): ?>
                <th class="ps-5"><a href="auth.php?t=auth" class="btn btn-primary">Зайти в аккаунт</a></th>
            <?php else: ?>
                <th class="ps-5">Привет, <?= $_SESSION['user'][0] ?><a href="auth.php?t=logout" class="btn btn-primary ms-2">Выйти</a></th>
            <?php endif; ?>
        </tr>
    </table>
    <div class="py-2"></div>
    <?php
    include "connect.php";
    if (!$conn) {
    die("Помилка: " . mysqli_connect_error());
    }
    $add = "";
    if (isset($_GET['filter']) && $_GET['filter'] != "") {
        $filter = $_GET["filter"];
        switch ($filter) {
            case "last":
                $add = " ORDER BY comments_id DESC";
                break;
            case "date":
                $add = " ORDER BY comment_date";
                break;
            case "date_":
                $add = " ORDER BY comment_date DESC";
                break;
            default:
                break;
        }
    }
    $sql = "SELECT * FROM Comments" . $add;

?>

<ul class="nav pb-4">
    
  <li class="nav-item ms-auto">
    <a class="nav-link" href="?">Первые записи</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="?filter=last">Последние записи</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="?filter=date">Сначала старые</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="?filter=date_">Сначала новые</a>
  </li>
</ul>

<?php

    if($result = mysqli_query($conn, $sql)){
        $result = $result->fetch_all();
        echo "<table class='table table-striped'><tr><th>Comments_id</th><th>Customer_text</th><th>Goods_id</th><th>Client_id<th>Comment_date</th>";
        if (isset($_SESSION['user']) && $_SESSION['user'][1] == 'admin') {
            echo "<th class='text-center'>Edit</th><th class='text-center'>Delete</th>";
        }
        echo "</tr>";
        foreach ($result as $i => $var){
            echo "<tr>";
            $id = $result[$i][0];
            foreach ($result[$i] as $td) {
                    echo "<td>" . $td . "</td>";
            }
            if (!isset($_SESSION['user']) || $_SESSION['user'][1] != 'admin') { continue; }
            echo "<td class='text-center'><a href='./update_Comments.php?id=" . $id . "'>" . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
          </svg>' . "</a></td>";
            echo "<td class='text-center'><a href='./delete_Comments.php?id=" . $id . "'>" . '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
          </svg>' . "</a></td>";
            echo "</tr>";
        }   
        echo "</table>";
        if (!isset($_SESSION['user']) || $_SESSION['user'][1] != 'admin') { return; }
        echo "<a class='btn btn-primary' href='./add_Comments.php'>Add comment</a>";
    } else{
        echo "Помилка: " . mysqli_error($conn);
    }
    mysqli_close($conn);
    ?>
</div>
