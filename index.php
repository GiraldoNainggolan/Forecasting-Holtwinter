<?php
include "koneksi.php";

$data = query("SELECT * FROM tabel_kunjungan ORDER BY tahun ASC, bulan ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        nav {
            background-color: #007bff;
            padding: 1rem;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            margin: 0 1rem;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 0.5rem 1rem;
            background-color: #0056b3;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #003d80;
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container a {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .container a:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        table th,
        table td {
            text-align: left;
            padding: 0.75rem;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            margin-right: 0.5rem;
            padding: 0.3rem 0.6rem;
            border-radius: 5px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .actions a.edit {
            background-color: #ffc107;
            color: white;
        }

        .actions a.edit:hover {
            background-color: #e0a800;
        }

        .actions a.delete {
            background-color: #dc3545;
            color: white;
        }

        .actions a.delete:hover {
            background-color: #bd2130;
        }
    </style>
</head>

<body>
    <nav>
        <ul>
            <!-- <li><a href="index.php">Olah Data</a></li> -->
            <!-- <li><a href="peramalan.php">Forecasting</a></li> -->
        </ul>
    </nav>
    <div class="container">
        <!-- <a href="peramalan.php">Forecasting</a> -->
        <a href="proses/tambah.php">Tambah Data</a>
        <a href="proses/hasil.php">Forecasting</a>
        <table>
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>Bulan</th>
                    <th>Jumlah Pengunjung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $i): ?>
                    <?php
                    $bulanNama = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ][$i["bulan"] - 1];
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($i["periode"]); ?></td>
                        <td><?= htmlspecialchars($i["tahun"]); ?></td>
                        <td><?= htmlspecialchars($bulanNama); ?></td>
                        <td><?= htmlspecialchars($i["jumlah_pengunjung"]); ?></td>
                        <td class="actions">
                            <a href="proses/edit.php?id=<?= $i["id_kunjungan"]; ?>" class="edit">Edit</a>
                            <a href="proses/hapus.php?id=<?= $i["id_kunjungan"]; ?>" class="delete" onclick="return confirm('Apa anda yakin ingin menghapus data pada bulan <?= $bulanNama . ' ' . $i["tahun"]; ?>?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
