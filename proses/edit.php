<?php

include "../koneksi.php";

$id = $_GET["id"];
$data = query("SELECT * FROM tabel_kunjungan WHERE id_kunjungan = $id")[0];

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $idwisata = $_POST["id_wisata"];
    $bulan = $_POST["bulan"];
    $tahun = $_POST["tahun"];
    $jumlah = $_POST["jumlah"];

    mysqli_query($koneksi, "UPDATE `tabel_kunjungan` SET `id_wisata`='$idwisata',`periode`='0',`bulan`='$bulan',`tahun`='$tahun',`jumlah_pengunjung`='$jumlah' WHERE id_kunjungan = '$id'");

    if (mysqli_affected_rows($koneksi) === 0) {
    } else {
        // hapus tabel periode
        mysqli_query($koneksi, "ALTER TABLE tabel_kunjungan DROP COLUMN periode");
        // buat lagi tabel periode
        mysqli_query($koneksi, "ALTER TABLE tabel_kunjungan ADD COLUMN periode INT AFTER id_wisata");

        // isi tabel periode
        mysqli_multi_query($koneksi, "SET @counter = 0; 
                                    UPDATE tabel_kunjungan 
                                    SET periode = (@counter := @counter + 1) 
                                    ORDER BY tahun ASC, bulan ASC;");

        echo "<script>
                    alert('Data Berhasil Diedit!');
                    document.location.href = '../index.php';
                    </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<body>
    <form action="" method="post">
        <input type="hidden" value="<?= $data["id_kunjungan"]; ?>" name="id">
        <input type="hidden" value="<?= $data["id_wisata"]; ?>" name="id_wisata">
        <label for="">Tahun</label>
        <input type="number" value="<?= $data["tahun"]; ?>" name="tahun" id="">
        <br>
        <label for="">Bulan</label>
        <select name="bulan" id="">
            <option value="1" <?= $data["bulan"] == 1 ? "selected" : ""; ?>>Januari</option>
            <option value="2" <?= $data["bulan"] == 2 ? "selected" : ""; ?>>Februari</option>
            <option value="3" <?= $data["bulan"] == 3 ? "selected" : ""; ?>>Maret</option>
            <option value="4" <?= $data["bulan"] == 4 ? "selected" : ""; ?>>April</option>
            <option value="5" <?= $data["bulan"] == 5 ? "selected" : ""; ?>>Mei</option>
            <option value="6" <?= $data["bulan"] == 6 ? "selected" : ""; ?>>Juni</option>
            <option value="7" <?= $data["bulan"] == 7 ? "selected" : ""; ?>>Juli</option>
            <option value="8" <?= $data["bulan"] == 8 ? "selected" : ""; ?>>Agustus</option>
            <option value="9" <?= $data["bulan"] == 9 ? "selected" : ""; ?>>September</option>
            <option value="10" <?= $data["bulan"] == 10 ? "selected" : ""; ?>>Oktober</option>
            <option value="11" <?= $data["bulan"] == 11 ? "selected" : ""; ?>>November</option>
            <option value="12" <?= $data["bulan"] == 12 ? "selected" : ""; ?>>Desember</option>
        </select>
        <br>
        <label for="">Jumlah Pengunjung</label>
        <input type="number" value="<?= $data["jumlah_pengunjung"]; ?>" name="jumlah" id="">
        <br>
        <button type="submit" name="submit">Edit data</button>
        <a href="../index.php">Kembali</a>
    </form>
</body>


</html>