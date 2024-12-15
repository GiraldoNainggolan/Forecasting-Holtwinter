<?php

include "../koneksi.php";

if (isset($_POST["submit"])) {

    // ambil data dari form

    $tahun = $_POST["tahun"];
    $bulan = $_POST["bulan"];
    $jumlah = $_POST["jumlah"];

    // cek apakah data ada

    $cekdata = mysqli_query($koneksi, "SELECT * FROM tabel_kunjungan WHERE tahun = $tahun AND bulan = $bulan");

    if (mysqli_num_rows($cekdata) === 0) {

        // masukan data jika belum ada

        mysqli_query($koneksi, "INSERT INTO tabel_kunjungan VALUES ('','1','0','$bulan','$tahun','$jumlah')");
        if (mysqli_affected_rows($koneksi) === 0) {
            echo "<script>alert('Data Gagal Ditambahkan!');</script>";
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
                    alert('Data Berhasil Ditambah!');
                    document.location.href = '../index.php';
                    </script>";
        }
    }
} else {

    // data tidak dimasukan jika sudah ada

    echo "<script>alert('Data Pada Tanggal Tersebut Sudah Ada!');</script>";
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
        <label for="">Tahun</label>
        <input type="number" name="tahun" id="">
        <br>
        <label for="">Bulan</label>
        <select name="bulan" id="">
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>
        <br>
        <label for="">Jumlah Pengunjung</label>
        <input type="number" name="jumlah" id="">
        <br>
        <button type="submit" name="submit">Tambah data</button>
        <a href="../index.php">Kembali</a>
    </form>
</body>

</html>