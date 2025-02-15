<?php
// view/admin/order/list.php

if (empty($orders)) {
    echo "<p>No orders found.</p>";
} else {
?>
    <h1>Order List</h1>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Shipping Address</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo number_format($order['total_price'], 2); ?> VND</td>
                    <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                    <td><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                    <td><?php echo date("d/m/Y H:i", strtotime($order['created_at'])); ?></td>
                    <td>
                        <!-- Link to view order details -->
                        <a href="index.php?controller=order&action=show&id=<?php echo $order['id']; ?>">View</a> |
                        <!-- Link to delete order -->
                        <a href="index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>
