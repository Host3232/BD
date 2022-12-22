<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<h3>Додавання клієнта</h3>
<form action="add_index.php" method="post">
    <p>ІD:
    <input type="text" name="client_name" /></p>
    <p>Ім'я:
    <input type="text" name="client_email" /></p>
    <p>Електронна адресса:
    <input type="number" name="client_address" /></p>
    <input type="submit" value="Добавить">
</form>
</body>
</html>