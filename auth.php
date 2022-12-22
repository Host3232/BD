<?php

session_start();

if (isset($_SESSION['msg'])) {
    echo("<script>alert('" . $_SESSION['msg'] . "')</script>");
    unset($_SESSION['msg']);
}

function err($msg) {
    $_SESSION['msg'] = $msg;
    header("Location: /");
    exit();
}

function check_post() {
    foreach ($_POST as $key => $value) {
        if ($_POST[$key] == "") {
            var_dump($key);
            err("Поле $key пусте!");
            break;
        }
    }
}

$is_auth = false;

if (isset($_SESSION['user'])) {
    $is_auth = true;
}

if (!empty($_POST)) {
    require 'connect.php';
    
    $type  = $_POST['type'];
    $login = $_POST['login'];
    $pass  = $_POST['password'];
    $login = mysqli_real_escape_string($conn, $login);
    if ($type == 'auth') {
        $sql = "SELECT * FROM users WHERE login = '$login'";
        $res = mysqli_query($conn, $sql);
        $res = mysqli_fetch_all($res);
        if (!$res) {
            err("ERROR NOT FOUND ACCOUNT");
            return;
        }
        $log  = $res[0][1];
        $pwd  = $res[0][2];
        $role = $res[0][3];

        if (password_verify($pass, $pwd)) {
            $_SESSION['user'] = [$log, $role];
            header("Location: /");
        } else {
            err("ERROR PASSWORD");
        }

    } else if ($type == 'reg') {

        
        if ($login != "" && $pass != "") {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $pass = mysqli_real_escape_string($conn, $pass);
    
            $sql = "INSERT INTO users (login, password, roles) VALUES ('$login', '$pass', 'user')";
            mysqli_query($conn, $sql);
            $_SESSION['user'] = [$login, 'user'];
            header("Location: /");
        } else {
            err("ERROR FIELD EMPTY");
        }
    }
}

function auth() {

if (!isset($_SESSION['user'])) {
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="w-100 h-100 d-flex justify-content-center">
        <form method="post" action="/auth.php" class="border mt-5 raduis px-3 py-3">
        <input type="hidden" name="type" value="auth">
            <h1 class="text-center fs-3">Вход</h1>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Логин</label>
                <input name="login" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary d-block mx-auto px-4 mt-4">Войти</button>
            <div class="fs-6 text-start pt-4"><a href="./auth.php?t=reg">Нету аккаунта?</a></div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    exit();
}

}

function reg() {

if (!isset($_SESSION['user'])) {
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="w-100 h-100 d-flex justify-content-center">
        <form method="post" action="/auth.php" class="border mt-5 raduis px-3 py-3">
            <input type="hidden" name="type" value="reg">
            <h1 class="text-center fs-3">Регистрация</h1>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Логин</label>
                <input name="login" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary d-block mx-auto px-4 mt-4">Зарегистрироваться</button>
            <div class="fs-6 text-start pt-4"><a href="./auth.php?t=auth">Есть аккаунт?</a></div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>

<?php
    exit();
}

}

if (!empty($_GET)) {
    if (isset($_GET['t'])) {
        $t = $_GET['t'];
        if ($t == 'auth') {
            auth();
        } else if ($t == 'reg') {
            reg();
        } else if ($t == 'logout') {
            unset($_SESSION['user']);
            header("Location: /");
        }
    }
}


if (!$is_auth) {
    auth();
}