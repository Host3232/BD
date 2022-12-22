<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<h3>Додавання товар</h3>
<form action="add_Goods.php" method="post">
    <p>ІD:
    <input type="text" name="name" /></p>
    <p>Ім'я:
    <input type="text" name="price" /></p>
    <p>Ціна:
    <input type="text" name="description" /></p>
    <p>Опис:
    <input type="number" name="availability" /></p>
    <input type="submit" value="Добавить">
</form>
</body>
</html>