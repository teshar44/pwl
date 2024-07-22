<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Data Transaksi</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Waktu Pembelian</th>
                <th>Total Bayar</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transaksi as $index => $item) : ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $item['id'] ?></td>
                <td><?= $item['created_at'] ?></td>
                <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                <td><?= $item['alamat'] ?></td>
                <td><?= $item['status'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
