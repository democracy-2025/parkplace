<?php
$db = new PDO('sqlite:restaurant.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$orders = $db->query("SELECT * FROM orders WHERE status='Pending' ORDER BY created_at ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kitchen Orders</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 80%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
<h2>Pending Orders</h2>
<table>
    <tr><th>ID</th><th>Customer</th><th>Items</th><th>Total</th><th>Time</th></tr>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $order['id'] ?></td>
        <td><?= htmlspecialchars($order['customer_name']) ?></td>
        <td><?= htmlspecialchars($order['items']) ?></td>
        <td>$<?= number_format($order['total'], 2) ?></td>
        <td><?php date_default_timezone_set('America/Denver');
                    $currentDateTime = date('m-d-Y h:i:s:A');
                    print $currentDateTime;
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
