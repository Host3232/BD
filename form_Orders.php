<?php require 'auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<h3>Додавання товар</h3>
<form action="add_Orders.php" method="post">
    <p>ІD:
    <input type="text" name="order_date" /></p>
    <p>Дата замовлення:
    <input type="text" name="goods_id" /></p>
    <p>Номер товару:
    <input type="number" name="price" /></p>
    <input type="submit" value="Добавить">
</form>
</body>
</html>