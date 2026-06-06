<?php
// setup.php - Run once to initialize the database
try {
    $db = new PDO('sqlite:restaurant.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create menu table
    $db->exec("CREATE TABLE IF NOT EXISTS menu (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        price REAL NOT NULL
    )");

    // Create orders table
    $db->exec("CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        customer_name TEXT NOT NULL,
        items TEXT NOT NULL,
        total REAL NOT NULL,
        status TEXT DEFAULT 'Pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Insert sample menu items
    $db->exec("INSERT INTO menu (name, price) VALUES
        ('Burger', 5.99),
        ('Pizza', 8.50),
        ('Pasta', 7.25),
        ('Salad', 4.50)
    ");

    echo "Database setup complete!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// index.php - Customer order form
$db = new PDO('sqlite:restaurant.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$menu = $db->query("SELECT * FROM menu")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Order</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
<h2>Place Your Order</h2>
<form method="POST" action="submit_order.php">
    <label>Customer Name:</label>
    <input type="text" name="customer_name" required><br><br>
    <table>
        <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
        <?php foreach ($menu as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td><input type="number" name="qty[<?= $item['id'] ?>]" min="0" value="0"></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <button type="submit">Submit Order</button>
</form>
</body>
</html>
