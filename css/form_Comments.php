<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<h3>Додавання коментарр</h3>
<form action="add_Comments.php" method="post">
    <p>Коментарр:
    <input type="text" name="customer_text" /></p>
    <p>Опис автомобіля:
    <input type="text" name="goods_id" /></p>
    <p>Номер телефону:
    <input type="text" name="client_id" /></p>
    <p>Номер телефону:
    <input type="number" name="comment_dater" /></p>
    <input type="submit" value="Добавить">
</form>
</body>
</html>