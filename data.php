<?php
if (!(isset($_SESSION["auth"]) && $_SESSION["auth"]=="admin" )){
    header("location:dashboard-stocks.php");
}
try {
    $db = new PDO('sqlite:../stock.db');
} catch (PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}
$productsQuery = $db->query("SELECT * FROM products");
$products = $productsQuery->fetchAll(PDO::FETCH_ASSOC);
$transactionsQuery = $db->query("SELECT * FROM transactions");
$transactions = $transactionsQuery->fetchAll(PDO::FETCH_ASSOC);
$logsQuery = $db->query("SELECT * FROM logs");
$logs = $logsQuery->fetchAll(PDO::FETCH_ASSOC);
$productNames = array();
$productStocks = array();
foreach ($products as $product) {
    $productNames[] = $product['name'];
    $productStocks[] = $product['stocks'];
}
$productNamesJson = json_encode($productNames);
$productStocksJson = json_encode($productStocks);
$transactionTypesCount = array();
foreach ($transactions as $trans) {
    $type = $trans['transaction_type'];
    if (!isset($transactionTypesCount[$type])) {
        $transactionTypesCount[$type] = 0;
    }
    $transactionTypesCount[$type]++;
}
$transactionTypes = array_keys($transactionTypesCount);
$transactionCounts = array_values($transactionTypesCount);
$transactionTypesJson = json_encode($transactionTypes);
$transactionCountsJson = json_encode($transactionCounts);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord <!-- Dashboard --></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Tableau de Bord <!-- Dashboard --></h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Stocks des Produits <!-- Product Stocks --></h3>
            <canvas id="productsChart"></canvas>
        </div>
    </div>
    <hr>
    <h2>Liste des Produits <!-- List of Products --></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom <!-- Name --></th>
                <th>Prix <!-- Price --></th>
                <th>Stock</th>
                <th>Date de Création <!-- Creation Date --></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['stocks']); ?></td>
                <td><?php echo htmlspecialchars($product['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr>
    <h2>Liste des Transactions <!-- List of Transactions --></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Produit <!-- Product ID --></th>
                <th>Type de Transaction <!-- Transaction Type --></th>
                <th>Prix de Transaction <!-- Transaction Price --></th>
                <th>Quantité <!-- Quantity --></th>
                <th>Commentaire <!-- Commentary --></th>
                <th>Date de Création <!-- Creation Date --></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo htmlspecialchars($transaction['id']); ?></td>
                <td><?php echo htmlspecialchars($transaction['product_id']); ?></td>
                <td><?php echo htmlspecialchars($transaction['transaction_type']); ?></td>
                <td><?php echo htmlspecialchars($transaction['transaction_price']); ?></td>
                <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                <td><?php echo htmlspecialchars($transaction['commentary']); ?></td>
                <td><?php echo htmlspecialchars($transaction['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr>
    <h2>Liste des Logs <!-- List of Logs --></h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Commentaire <!-- Commentary --></th>
                <th>Date de Création <!-- Creation Date --></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo htmlspecialchars($log['id']); ?></td>
                <td><?php echo htmlspecialchars($log['commentary']); ?></td>
                <td><?php echo htmlspecialchars($log['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
const productNames = <?php echo $productNamesJson; ?>;
const productStocks = <?php echo $productStocksJson; ?>;
const ctxProducts = document.getElementById('productsChart').getContext('2d');
const productsChart = new Chart(ctxProducts, {
    type: 'bar',
    data: {
        labels: productNames,
        datasets: [{
            label: 'Stock des produits <!-- Product Stock -->',
            data: productStocks,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
const transactionTypes = <?php echo $transactionTypesJson; ?>;
const transactionCounts = <?php echo $transactionCountsJson; ?>;
const ctxTransactions = document.getElementById('transactionsChart').getContext('2d');
const transactionsChart = new Chart(ctxTransactions, {
    type: 'pie',
    data: {
        labels: transactionTypes,
        datasets: [{
            label: 'Répartition des transactions <!-- Transactions Distribution -->',
            data: transactionCounts,
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(153, 102, 255, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: { responsive: true }
});
</script>
</body>
</html>


