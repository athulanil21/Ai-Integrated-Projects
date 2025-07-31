<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body { background: #f4f6f8; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; }
        .cart-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            min-width: 350px;
            max-width: 600px;
            margin: 80px auto 0 auto;
        }
        h2 { color: #333; margin-bottom: 1.5rem; text-align:center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        th, td { padding: 0.7rem; text-align: left; }
        th { background: #f4f6f8; color: #007bff; }
        tr:nth-child(even) { background: #f9f9f9; }
        .total { font-weight: bold; color: #222; }
        .empty { color: #888; text-align: center; margin: 2rem 0; }
        .back-btn { background: #007bff; color: #fff; border: none; border-radius: 5px; padding: 0.6rem 1.2rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .back-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Your Cart</h2>
        <?php if(empty($cart)): ?>
            <div class="empty">Your cart is empty.</div>
        <?php else: ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php $total = 0; foreach($cart as $item): $subtotal = $item['price'] * $item['qty']; $total += $subtotal; ?>
            <tr>
                <td><?= esc($item['title']) ?></td>
                <td>$<?= number_format($item['price'],2) ?></td>
                <td><?= $item['qty'] ?></td>
                <td>$<?= number_format($subtotal,2) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="total">$<?= number_format($total,2) ?></td>
            </tr>
        </table>
        <?php endif; ?>
        <a href="<?= site_url('user/home') ?>"><button class="back-btn">Back to Home</button></a>
    </div>
</body>
</html>
