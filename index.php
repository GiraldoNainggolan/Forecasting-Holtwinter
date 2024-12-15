<?php
include "koneksi.php";

$data = query("SELECT * FROM tabel_kunjungan ORDER BY tahun ASC, bulan ASC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav>
        <ul>
            <li><a href="index.php">Olah Data</a></li>
            <li><a href="peramalan.php">Forecasting</a></li>
        </ul>
    </nav>
    <a href="proses/tambah.php">Tambah Data</a>
    <table border="1">
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
            <?php
            foreach ($data as $i):
            ?>
                <tr>
                    <td><?= $i["periode"]; ?></td>
                    <td><?= $i["tahun"]; ?></td>
                    <?php
                    $bulanNama = '';
                    if ($i["bulan"] == 1) {
                        $bulanNama = "Januari";
                    } elseif ($i["bulan"] == 2) {
                        $bulanNama = "Februari";
                    } elseif ($i["bulan"] == 3) {
                        $bulanNama = "Maret";
                    } elseif ($i["bulan"] == 4) {
                        $bulanNama = "April";
                    } elseif ($i["bulan"] == 5) {
                        $bulanNama = "Mei";
                    } elseif ($i["bulan"] == 6) {
                        $bulanNama = "Juni";
                    } elseif ($i["bulan"] == 7) {
                        $bulanNama = "Juli";
                    } elseif ($i["bulan"] == 8) {
                        $bulanNama = "Agustus";
                    } elseif ($i["bulan"] == 9) {
                        $bulanNama = "September";
                    } elseif ($i["bulan"] == 10) {
                        $bulanNama = "Oktober";
                    } elseif ($i["bulan"] == 11) {
                        $bulanNama = "November";
                    } elseif ($i["bulan"] == 12) {
                        $bulanNama = "Desember";
                    }
                    ?>
                    <td><?= $bulanNama; ?></td>
                    <td><?= $i["jumlah_pengunjung"]; ?></td>
                    <?php
                    $tahun = $i["tahun"];
                    ?>
                    <td><a href="proses/edit.php?id=<?= $i["id_kunjungan"]; ?>">Edit</a> |
                        <a href="proses/hapus.php?id=<?= $i["id_kunjungan"]; ?>" onclick="return confirm('Apa anda yakin ingin menghapus data pada bulan <?= $bulanNama . ' ' . $tahun; ?> ?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>