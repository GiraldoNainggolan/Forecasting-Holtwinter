<?php

include "../koneksi.php";

$id = $_GET["id"];

mysqli_query($koneksi, "DELETE FROM tabel_kunjungan WHERE id_kunjungan = $id");

if (mysqli_affected_rows($koneksi) === 0) {
  echo "<script>
            alert('Data Gagal Dihapus!');
            document.location.href = '../index.php';
          </script>";
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
            alert('Data Berhasil Dihapus!');
            document.location.href = '../index.php';
          </script>";
}
