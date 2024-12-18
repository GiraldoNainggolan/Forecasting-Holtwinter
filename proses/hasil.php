<!DOCTYPE html>
<html>
<?php
$_GET["id_wisata"] = 1;
include "../koneksi.php";
?>

<head>

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

    <!-- start Proses -->
     <br>
    <div hidden>
        <!-- <h1>mencari nilai alfa</h1> -->
         <b>
        <?php
        //mencari nilai alfa
        $alfa = 0.01;
        $beta = 0.99;
        $gamma = 0.99;
        while ($alfa < 1) {
            ?>
        </b>
            <table border="1" hidden>
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">PENGUNJUNG</th>
                        <th colspan="6">Aditif</th>
                        <th colspan="6">Multiplikatif</th>
                    </tr>
                    <tr>
                        <th>AT</th>
                        <th>TT</th>
                        <th>ST</th>
                        <th>F</th>
                        <th>E</th>
                        <th>ABS(E/P)</th>
                        <th>AT</th>
                        <th>TT</th>
                        <th>ST</th>
                        <th>F</th>
                        <th>E</th>
                        <th>ABS(E/P)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $smoting = 0;
                    //inisialisasi level (AT)
                    $data = mysqli_query($koneksi, "SELECT AVG(jumlah_pengunjung) AS a FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12;");
                    $at = mysqli_fetch_array($data);
                    //inisialisasi trend (TT)
                    $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim1 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12");
                    $jumlah_musim1 = mysqli_fetch_array($data);
                    $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim2 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 13 AND 24");
                    $jumlah_musim2 = mysqli_fetch_array($data);
                    $selisih = $jumlah_musim2['jumlah_musim2'] - $jumlah_musim1['jumlah_musim1'];
                    $data = mysqli_query($koneksi, "SELECT ($selisih) / POW (12, 2) AS tt");
                    $tt = mysqli_fetch_array($data);
                    //data pengunjung
                    $data = mysqli_query($koneksi, "SELECT periode, (jumlah_pengunjung) AS st FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]' ORDER BY periode");
                    $baris = mysqli_num_rows($data);
                    while ($st = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <!--aditif-->
                            <td>
                                <?php
                                //periode
                                if ($st['periode'] <= 12) {
                                    echo $no++;
                                } else {
                                    $periode_ar[] = $no;
                                    echo $no++;
                                } ?>
                            </td>
                            <td>
                                <?php
                                //pengunjung
                                if ($st['periode'] <= 12) {
                                    echo number_format($st['st'], 2, ",", ".");
                                } else {
                                    echo number_format($pengunjung = $st['st'], 2, ",", ".");
                                    $pengunjung_ar[] = $pengunjung;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_level = $at['a'], 2, ",", ".");
                                    $level_ar[] = $i_level;
                                } else {
                                    //smoting level (AT-A)
                                    echo number_format($i_level = $alfa * ($st['st'] - $musim_ar[$smoting]) + (1 - $alfa) * ($level_ar[$smoting] + $trend_ar[$smoting]), 2, ",", ".");
                                    $level_ar[] = $i_level;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_trend = $tt['tt'], 2, ",", ".");
                                    $trend_ar[] = $i_trend;
                                } else {
                                    //smoting trend (TT-A)
                                    echo number_format($i_trend = $beta * ($i_level - $level_ar[$smoting]) + (1 - $beta) * $trend_ar[$smoting], 2, ",", ".");
                                    $trend_ar[] = $i_trend;
                                }; ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] <= 12) {
                                    //inisialisasi musim (ST-A)
                                    echo number_format($i_musim = $st['st'] - $at['a'], 2, ",", ".");
                                    $musim_ar[] = $i_musim;
                                } else {
                                    //smoting musim (ST-A)
                                    echo number_format($i_musim = $gamma * ($st['st'] - $i_level) + (1 - $gamma) * $musim_ar[$smoting], 2, ",", ".");
                                    $musim_ar[] = $i_musim;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] > 12) {
                                    //prediksi-A
                                    echo number_format($i_prediksi = $level_ar[$smoting] + $trend_ar[$smoting] + $musim_ar[$smoting], 2, ",", ".");
                                    $prediksi_ar[] = $i_prediksi;
                                } else {
                                    //inisialisasi prediksi-A
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //error-A
                                if ($st['periode'] > 12) {
                                    echo number_format($error = $i_prediksi - $st['st'], 2, ",", ".");
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //abs error-A
                                if ($st['periode'] > 12) {
                                    echo number_format($abs = abs($st['st'] - $i_prediksi) / $st['st'], 2, ",", ".");
                                    $jumlah_ar[] = $abs;
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <!--multiplikatif-->
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_level_m = $at['a'], 2, ",", ".");
                                    $level_m_ar[] = $i_level_m;
                                } else {
                                    //smoting level (AT-M)
                                    echo number_format($i_level_m = $alfa * ($st['st'] / $musim_m_ar[$smoting]) + (1 - $alfa) * ($level_m_ar[$smoting] + $trend_m_ar[$smoting]), 2, ",", ".");
                                    $level_m_ar[] = $i_level_m;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_trend_m = $tt['tt'], 2, ",", ".");
                                    $trend_m_ar[] = $i_trend_m;
                                } else {
                                    //smoting trend (TT-M)
                                    echo number_format($i_trend_m = $beta * ($i_level_m - $level_m_ar[$smoting]) + (1 - $beta) * $trend_m_ar[$smoting], 2, ",", ".");
                                    $trend_m_ar[] = $i_trend_m;
                                }; ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] <= 12) {
                                    //inisialisasi musim (ST-M)
                                    echo number_format($i_musim_m = $st['st'] / $at['a'], 2, ",", ".");
                                    $musim_m_ar[] = $i_musim_m;
                                } else {
                                    //smoting musim (ST-M)
                                    echo number_format($i_musim_m = $gamma * ($st['st'] / $i_level_m) + (1 - $gamma) * $musim_m_ar[$smoting], 2, ",", ".");
                                    $musim_m_ar[] = $i_musim_m;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] > 12) {
                                    //prediksi-M
                                    echo number_format($i_prediksi_m = ($level_m_ar[$smoting] + $trend_m_ar[$smoting]) * $musim_m_ar[$smoting], 2, ",", ".");
                                    $prediksi_m_ar[] = $i_prediksi_m;
                                    $smoting++;
                                } else {
                                    //inisialisasi prediksi-M
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //error-M
                                if ($st['periode'] > 12) {
                                    echo number_format($error_m = $st['st'] - $i_prediksi_m, 2, ",", ".");
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //abs error-M
                                if ($st['periode'] > 12) {
                                    echo number_format($abs_m = abs($error_m) / ((abs($st['st']) + abs($i_prediksi_m)) / 2), 2, ",", ".");
                                    $jumlah_m_ar[] = $abs_m;
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
            // echo "alfa = $alfa <br/>";
            // echo "beta = $beta <br/>";
            // echo "gamma = $gamma <br/>";
            // echo "Metode Holt-Winter Aditif =";
            $mape = 100 / count($jumlah_ar) * array_sum($jumlah_ar);
            // echo number_format($mape, 2, ",", ".");
            // echo "%<br/>";
            // echo "Metode Holt-Winter Multiplikatif =";
            $mape_m = 100 / count($jumlah_m_ar) * array_sum($jumlah_m_ar);
            // echo number_format($mape_m, 2, ",", ".");
            // echo "%<br/>";
            $alfa_ar[] = $alfa;
            $mape_ar[] = $mape;
            $mape_m_ar[] = $mape_m;
            //print_r($gamma_ar);
            //echo "<br/>";
            //print_r($mape_ar);
            //echo "<br/>";
            // echo "<br/>";
            unset($periode_ar);
            unset($pengunjung_ar);
            unset($level_ar);
            unset($trend_ar);
            unset($musim_ar);
            unset($prediksi_ar);
            unset($jumlah_ar);
            unset($level_m_ar);
            unset($trend_m_ar);
            unset($musim_m_ar);
            unset($prediksi_m_ar);
            unset($jumlah_m_ar);
            $alfa = $alfa + 0.01;
        } ?>
        <?php
        //print_r(min($mape_ar));
        //echo "<br/>";
        //echo "<br/>";
        $parameter = min($mape_ar);
        //print_r(array_keys($mape_ar, $parameter));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_key = array_keys($mape_ar, $parameter);
        foreach ($parameter_key as $key) {
        }
        $alfa_a = $alfa_ar[$key];
        // echo "nilai Alfa A : $alfa_a";
        // echo "<br/>";
        //print_r(min($mape_ar));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_m = min($mape_m_ar);
        //print_r(array_keys($mape_ar, $parameter));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_m_key = array_keys($mape_m_ar, $parameter_m);
        foreach ($parameter_m_key as $key_m) {
        }
        $alfa_m = $alfa_ar[$key_m];
        // echo "nilai Alfa M : $alfa_m";
        // echo "<br/>";
        unset($mape_ar);
        unset($mape_m_ar);
        unset($alfa_ar);
        ?>
        <!-- <h1>mencari nilai beta</h1> -->
        <?php
        //mencari nilai beta
        $beta = 0.01;
        $gamma = 0.99;
        while ($beta < 1) {
        ?>
            <table border="1" hidden>
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">PENGUNJUNG</th>
                        <th colspan="6">Aditif</th>
                        <th colspan="6">Multiplikatif</th>
                    </tr>
                    <tr>
                        <th>AT</th>
                        <th>TT</th>
                        <th>ST</th>
                        <th>F</th>
                        <th>E</th>
                        <th>ABS(E/P)</th>
                        <th>AT</th>
                        <th>TT</th>
                        <th>ST</th>
                        <th>F</th>
                        <th>E</th>
                        <th>ABS(E/P)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $smoting = 0;
                    //inisialisasi level (AT)
                    $data = mysqli_query($koneksi, "SELECT AVG(jumlah_pengunjung) AS a FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12;");
                    $at = mysqli_fetch_array($data);
                    //inisialisasi trend (TT)
                    $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim1 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12");
                    $jumlah_musim1 = mysqli_fetch_array($data);
                    $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim2 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 13 AND 24");
                    $jumlah_musim2 = mysqli_fetch_array($data);
                    $selisih = $jumlah_musim2['jumlah_musim2'] - $jumlah_musim1['jumlah_musim1'];
                    $data = mysqli_query($koneksi, "SELECT ($selisih) / POW (12, 2) AS tt");
                    $tt = mysqli_fetch_array($data);
                    //data pengunjung
                    $data = mysqli_query($koneksi, "SELECT periode, (jumlah_pengunjung) AS st FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]' ORDER BY periode");
                    $baris = mysqli_num_rows($data);
                    while ($st = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <!--aditif-->
                            <td>
                                <?php
                                //periode
                                if ($st['periode'] <= 12) {
                                    echo $no++;
                                } else {
                                    $periode_ar[] = $no;
                                    echo $no++;
                                } ?>
                            </td>
                            <td>
                                <?php
                                //pengunjung
                                if ($st['periode'] <= 12) {
                                    echo number_format($st['st'], 2, ",", ".");
                                } else {
                                    echo number_format($pengunjung = $st['st'], 2, ",", ".");
                                    $pengunjung_ar[] = $pengunjung;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_level = $at['a'], 2, ",", ".");
                                    $level_ar[] = $i_level;
                                } else {
                                    //smoting level (AT-A)
                                    echo number_format($i_level = $alfa_a * ($st['st'] - $musim_ar[$smoting]) + (1 - $alfa_a) * ($level_ar[$smoting] + $trend_ar[$smoting]), 2, ",", ".");
                                    $level_ar[] = $i_level;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_trend = $tt['tt'], 2, ",", ".");
                                    $trend_ar[] = $i_trend;
                                } else {
                                    //smoting trend (TT-A)
                                    echo number_format($i_trend = $beta * ($i_level - $level_ar[$smoting]) + (1 - $beta) * $trend_ar[$smoting], 2, ",", ".");
                                    $trend_ar[] = $i_trend;
                                }; ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] <= 12) {
                                    //inisialisasi musim (ST-A)
                                    echo number_format($i_musim = $st['st'] - $at['a'], 2, ",", ".");
                                    $musim_ar[] = $i_musim;
                                } else {
                                    //smoting musim (ST-A)
                                    echo number_format($i_musim = $gamma * ($st['st'] - $i_level) + (1 - $gamma) * $musim_ar[$smoting], 2, ",", ".");
                                    $musim_ar[] = $i_musim;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] > 12) {
                                    //prediksi-A
                                    echo number_format($i_prediksi = $level_ar[$smoting] + $trend_ar[$smoting] + $musim_ar[$smoting], 2, ",", ".");
                                    $prediksi_ar[] = $i_prediksi;
                                } else {
                                    //inisialisasi prediksi-A
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //error-A
                                if ($st['periode'] > 12) {
                                    echo number_format($error = $i_prediksi - $st['st'], 2, ",", ".");
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //abs error-A
                                if ($st['periode'] > 12) {
                                    echo number_format($abs = abs($st['st'] - $i_prediksi) / $st['st'], 2, ",", ".");
                                    $jumlah_ar[] = $abs;
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <!--multiplikatif-->
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_level_m = $at['a'], 2, ",", ".");
                                    $level_m_ar[] = $i_level_m;
                                } else {
                                    //smoting level (AT-M)
                                    echo number_format($i_level_m = $alfa_m * ($st['st'] / $musim_m_ar[$smoting]) + (1 - $alfa_m) * ($level_m_ar[$smoting] + $trend_m_ar[$smoting]), 2, ",", ".");
                                    $level_m_ar[] = $i_level_m;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_trend_m = $tt['tt'], 2, ",", ".");
                                    $trend_m_ar[] = $i_trend_m;
                                } else {
                                    //smoting trend (TT-M)
                                    echo number_format($i_trend_m = $beta * ($i_level_m - $level_m_ar[$smoting]) + (1 - $beta) * $trend_m_ar[$smoting], 2, ",", ".");
                                    $trend_m_ar[] = $i_trend_m;
                                }; ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] <= 12) {
                                    //inisialisasi musim (ST-M)
                                    echo number_format($i_musim_m = $st['st'] / $at['a'], 2, ",", ".");
                                    $musim_m_ar[] = $i_musim_m;
                                } else {
                                    //smoting musim (ST-M)
                                    echo number_format($i_musim_m = $gamma * ($st['st'] / $i_level_m) + (1 - $gamma) * $musim_m_ar[$smoting], 2, ",", ".");
                                    $musim_m_ar[] = $i_musim_m;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] > 12) {
                                    //prediksi-M
                                    echo number_format($i_prediksi_m = ($level_m_ar[$smoting] + $trend_m_ar[$smoting]) * $musim_m_ar[$smoting], 2, ",", ".");
                                    $prediksi_m_ar[] = $i_prediksi_m;
                                    $smoting++;
                                } else {
                                    //inisialisasi prediksi-M
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //error-M
                                if ($st['periode'] > 12) {
                                    echo number_format($error_m = $st['st'] - $i_prediksi_m, 2, ",", ".");
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //abs error-M
                                if ($st['periode'] > 12) {
                                    echo number_format($abs_m = abs($error_m) / ((abs($st['st']) + abs($i_prediksi_m)) / 2), 2, ",", ".");
                                    $jumlah_m_ar[] = $abs_m;
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
            // echo "alfa A = $alfa_a <br/>";
            // echo "beta = $beta <br/>";
            // echo "gamma = $gamma <br/>";
            // echo "Metode Holt-Winter Aditif =";
            $mape = 100 / count($jumlah_ar) * array_sum($jumlah_ar);
            // echo number_format($mape, 2, ",", ".");
            // echo "%<br/>";
            // echo "alfa M = $alfa_m <br/>";
            // echo "beta = $beta <br/>";
            // echo "gamma = $gamma <br/>";
            // echo "Metode Holt-Winter Multiplikatif =";
            $mape_m = 100 / count($jumlah_m_ar) * array_sum($jumlah_m_ar);
            // echo number_format($mape_m, 2, ",", ".");
            // echo "%<br/>";
            $beta_ar[] = $beta;
            $mape_ar[] = $mape;
            $mape_m_ar[] = $mape_m;
            //print_r($gamma_ar);
            //echo "<br/>";
            //print_r($mape_ar);
            //echo "<br/>";
            // echo "<br/>";
            unset($periode_ar);
            unset($pengunjung_ar);
            unset($level_ar);
            unset($trend_ar);
            unset($musim_ar);
            unset($prediksi_ar);
            unset($jumlah_ar);
            unset($level_m_ar);
            unset($trend_m_ar);
            unset($musim_m_ar);
            unset($prediksi_m_ar);
            unset($jumlah_m_ar);
            $beta = $beta + 0.01;
        } ?>
        <?php
        //print_r(min($mape_ar));
        //echo "<br/>";
        //echo "<br/>";
        $parameter = min($mape_ar);
        //print_r(array_keys($mape_ar, $parameter));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_key = array_keys($mape_ar, $parameter);
        foreach ($parameter_key as $key) {
        }
        $beta_a = $beta_ar[$key];
        // echo "nilai Alfa A : $alfa_a";
        // echo "<br/>";
        // echo "nilai Beta A : $beta_a";
        // echo "<br/>";
        //print_r(min($mape_m_ar));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_m = min($mape_m_ar);
        //print_r(array_keys($mape_m_ar, $parameter_m));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_m_key = array_keys($mape_m_ar, $parameter_m);
        foreach ($parameter_m_key as $key_m) {
        }
        $beta_m = $beta_ar[$key_m];
        // echo "nilai Alfa M : $alfa_m";
        // echo "<br/>";
        // echo "nilai Beta M : $beta_m";
        // echo "<br/>";
        unset($beta_ar);
        unset($mape_ar);
        unset($mape_m_ar);
        ?>
        <!-- <h1>mencari nilai gamma A</h1> -->
        <?php
        //mencari nilai gamma aditif
        $gamma = 0.01;
        while ($gamma < 1) {
        ?>
            <table border="1" hidden>
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">PENGUNJUNG</th>
                        <th colspan="6">Aditif</th>
                        <th colspan="6">Multiplikatif</th>
                    </tr>
                    <tr>
                        <th>AT</th>
                        <th>TT</th>
                        <th>ST</th>
                        <th>F</th>
                        <th>E</th>
                        <th>ABS(E/P)</th>
                        <th>AT</th>
                        <th>TT</th>
                        <th>ST</th>
                        <th>F</th>
                        <th>E</th>
                        <th>ABS(E/P)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $smoting = 0;
                    //inisialisasi level (AT)
                    $data = mysqli_query($koneksi, "SELECT AVG(jumlah_pengunjung) AS a FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12;");
                    $at = mysqli_fetch_array($data);
                    //inisialisasi trend (TT)
                    $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim1 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12");
                    $jumlah_musim1 = mysqli_fetch_array($data);
                    $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim2 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 13 AND 24");
                    $jumlah_musim2 = mysqli_fetch_array($data);
                    $selisih = $jumlah_musim2['jumlah_musim2'] - $jumlah_musim1['jumlah_musim1'];
                    $data = mysqli_query($koneksi, "SELECT ($selisih) / POW (12, 2) AS tt");
                    $tt = mysqli_fetch_array($data);
                    //data pengunjung
                    $data = mysqli_query($koneksi, "SELECT periode, (jumlah_pengunjung) AS st FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]' ORDER BY periode");
                    $baris = mysqli_num_rows($data);
                    while ($st = mysqli_fetch_array($data)) {
                    ?>
                        <tr>
                            <!--aditif-->
                            <td>
                                <?php
                                //periode
                                if ($st['periode'] <= 12) {
                                    echo $no++;
                                } else {
                                    $periode_ar[] = $no;
                                    echo $no++;
                                } ?>
                            </td>
                            <td>
                                <?php
                                //pengunjung
                                if ($st['periode'] <= 12) {
                                    echo number_format($st['st'], 2, ",", ".");
                                } else {
                                    echo number_format($pengunjung = $st['st'], 2, ",", ".");
                                    $pengunjung_ar[] = $pengunjung;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_level = $at['a'], 2, ",", ".");
                                    $level_ar[] = $i_level;
                                } else {
                                    //smoting level (AT-A)
                                    echo number_format($i_level = $alfa_a * ($st['st'] - $musim_ar[$smoting]) + (1 - $alfa_a) * ($level_ar[$smoting] + $trend_ar[$smoting]), 2, ",", ".");
                                    $level_ar[] = $i_level;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_trend = $tt['tt'], 2, ",", ".");
                                    $trend_ar[] = $i_trend;
                                } else {
                                    //smoting trend (TT-A)
                                    echo number_format($i_trend = $beta_a * ($i_level - $level_ar[$smoting]) + (1 - $beta_a) * $trend_ar[$smoting], 2, ",", ".");
                                    $trend_ar[] = $i_trend;
                                }; ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] <= 12) {
                                    //inisialisasi musim (ST-A)
                                    echo number_format($i_musim = $st['st'] - $at['a'], 2, ",", ".");
                                    $musim_ar[] = $i_musim;
                                } else {
                                    //smoting musim (ST-A)
                                    echo number_format($i_musim = $gamma * ($st['st'] - $i_level) + (1 - $gamma) * $musim_ar[$smoting], 2, ",", ".");
                                    $musim_ar[] = $i_musim;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] > 12) {
                                    //prediksi-A
                                    echo number_format($i_prediksi = $level_ar[$smoting] + $trend_ar[$smoting] + $musim_ar[$smoting], 2, ",", ".");
                                    $prediksi_ar[] = $i_prediksi;
                                } else {
                                    //inisialisasi prediksi-A
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //error-A
                                if ($st['periode'] > 12) {
                                    echo number_format($error = $i_prediksi - $st['st'], 2, ",", ".");
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //abs error-A
                                if ($st['periode'] > 12) {
                                    echo number_format($abs = abs($st['st'] - $i_prediksi) / $st['st'], 2, ",", ".");
                                    $jumlah_ar[] = $abs;
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <!--multiplikatif-->
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_level_m = $at['a'], 2, ",", ".");
                                    $level_m_ar[] = $i_level_m;
                                } else {
                                    //smoting level (AT-M)
                                    echo number_format($i_level_m = $alfa_m * ($st['st'] / $musim_m_ar[$smoting]) + (1 - $alfa_m) * ($level_m_ar[$smoting] + $trend_m_ar[$smoting]), 2, ",", ".");
                                    $level_m_ar[] = $i_level_m;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] < 12) {
                                    echo number_format(0, 2, ",", ".");
                                } elseif ($st['periode'] == 12) {
                                    echo number_format($i_trend_m = $tt['tt'], 2, ",", ".");
                                    $trend_m_ar[] = $i_trend_m;
                                } else {
                                    //smoting trend (TT-M)
                                    echo number_format($i_trend_m = $beta_m * ($i_level_m - $level_m_ar[$smoting]) + (1 - $beta_m) * $trend_m_ar[$smoting], 2, ",", ".");
                                    $trend_m_ar[] = $i_trend_m;
                                }; ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] <= 12) {
                                    //inisialisasi musim (ST-M)
                                    echo number_format($i_musim_m = $st['st'] / $at['a'], 2, ",", ".");
                                    $musim_m_ar[] = $i_musim_m;
                                } else {
                                    //smoting musim (ST-M)
                                    echo number_format($i_musim_m = $gamma * ($st['st'] / $i_level_m) + (1 - $gamma) * $musim_m_ar[$smoting], 2, ",", ".");
                                    $musim_m_ar[] = $i_musim_m;
                                } ?>
                            </td>
                            <td>
                                <?php
                                if ($st['periode'] > 12) {
                                    //prediksi-M
                                    echo number_format($i_prediksi_m = ($level_m_ar[$smoting] + $trend_m_ar[$smoting]) * $musim_m_ar[$smoting], 2, ",", ".");
                                    $prediksi_m_ar[] = $i_prediksi_m;
                                    $smoting++;
                                } else {
                                    //inisialisasi prediksi-M
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //error-M
                                if ($st['periode'] > 12) {
                                    echo number_format($error_m = $st['st'] - $i_prediksi_m, 2, ",", ".");
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                            <td>
                                <?php
                                //abs error-M
                                if ($st['periode'] > 12) {
                                    echo number_format($abs_m = abs($error_m) / ((abs($st['st']) + abs($i_prediksi_m)) / 2), 2, ",", ".");
                                    $jumlah_m_ar[] = $abs_m;
                                } else {
                                    echo number_format(0, 2, ",", ".");
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php
            // echo "alfa A = $alfa_a <br/>";
            // echo "beta A = $beta_a <br/>";
            // echo "gamma A = $gamma <br/>";
            // echo "Metode Holt-Winter Aditif =";
            $mape = 100 / count($jumlah_ar) * array_sum($jumlah_ar);
            // echo number_format($mape, 2, ",", ".");
            // echo "%<br/>";
            // echo "alfa A = $alfa_m <br/>";
            // echo "beta A = $beta_m <br/>";
            // echo "gamma A = $gamma <br/>";
            // echo "Metode Holt-Winter Multiplikatif =";
            $mape_m = 100 / count($jumlah_m_ar) * array_sum($jumlah_m_ar);
            // echo number_format($mape_m, 2, ",", ".");
            // echo "%<br/>";
            $gamma_ar[] = $gamma;
            $mape_ar[] = $mape;
            $mape_m_ar[] = $mape_m;
            //print_r($gamma_ar);
            //echo "<br/>";
            //print_r($mape_ar);
            //echo "<br/>";
            // echo "<br/>";
            unset($periode_ar);
            unset($pengunjung_ar);
            unset($level_ar);
            unset($trend_ar);
            unset($musim_ar);
            unset($prediksi_ar);
            unset($jumlah_ar);
            unset($level_m_ar);
            unset($trend_m_ar);
            unset($musim_m_ar);
            unset($prediksi_m_ar);
            unset($jumlah_m_ar);
            $gamma = $gamma + 0.01;
        } ?>
        <?php
        //print_r(min($mape_ar));
        //echo "<br/>";
        //echo "<br/>";
        $parameter = min($mape_ar);
        //print_r(array_keys($mape_ar, $parameter));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_key = array_keys($mape_ar, $parameter);
        foreach ($parameter_key as $key) {
        }
        $gamma_a = $gamma_ar[$key];
        // echo "nilai Alfa A : $alfa_a";
        // echo "<br/>";
        // echo "nilai Beta A : $beta_a";
        // echo "<br/>";
        // echo "nilai Gamma A : $gamma_a";
        // echo "<br/>";
        //print_r(min($mape_m_ar));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_m = min($mape_m_ar);
        //print_r(array_keys($mape_m_ar, $parameter_m));
        //echo "<br/>";
        //echo "<br/>";
        $parameter_m_key = array_keys($mape_m_ar, $parameter_m);
        foreach ($parameter_m_key as $key_m) {
        }
        $gamma_m = $gamma_ar[$key_m];
        // echo "nilai Alfa M : $alfa_m";
        // echo "<br/>";
        // echo "nilai Beta M : $beta_m";
        // echo "<br/>";
        // echo "nilai Gamma M : $gamma_m";
        // echo "<br/>";
        unset($gamma_ar);
        unset($mape_ar);
        unset($mape_m_ar);
        ?>
    </div>
    <!-- end Proses -->

    <?php
    echo "Alpha : ";
    echo $alfa_a;
    echo "<br>";
    echo "Beta : ";
    echo $beta_a;
    echo "<br>";
    echo "Gamma : ";
    echo $gamma_a
    ?>
    <table border="1">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">PENGUNJUNG</th>

            </tr>
            <tr>
                <th>AT</th>
                <th>TT</th>
                <th>ST</th>
                <th>F</th>
                <th>E</th>
                <th>ABS(E/P)</th>
            </tr>
        </thead>
        <!-- <tfoot>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">PENGUNJUNG</th>

            </tr>
            <tr>
                <th>AT</th>
                <th>TT</th>
                <th>ST</th>
                <th>F</th>
                <th>E</th>
                <th>ABS(E/P)</th>
            </tr>
        </tfoot> -->
        <tbody>
            <?php
            $no = 1;
            $smoting = 0;
            //inisialisasi level (AT)
            $data = mysqli_query($koneksi, "SELECT AVG(jumlah_pengunjung) AS a FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12;");
            $at = mysqli_fetch_array($data);
            //inisialisasi trend (TT)
            $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim1 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 1 AND 12");
            $jumlah_musim1 = mysqli_fetch_array($data);
            $data = mysqli_query($koneksi, "SELECT SUM(jumlah_pengunjung) AS jumlah_musim2 FROM (SELECT * FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]') AS kunjungan WHERE periode BETWEEN 13 AND 24");
            $jumlah_musim2 = mysqli_fetch_array($data);
            $selisih = $jumlah_musim2['jumlah_musim2'] - $jumlah_musim1['jumlah_musim1'];
            $data = mysqli_query($koneksi, "SELECT ($selisih) / POW (12, 2) AS tt");
            $tt = mysqli_fetch_array($data);
            //data pengunjung
            $data = mysqli_query($koneksi, "SELECT periode, (jumlah_pengunjung) AS st FROM tabel_kunjungan WHERE id_wisata = '$_GET[id_wisata]' ORDER BY periode");
            $baris = mysqli_num_rows($data);
            while ($st = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <!--aditif-->
                    <td>
                        <?php
                        //periode
                        if ($st['periode'] <= 12) {
                            echo $no++;
                        } else {
                            $periode_ar[] = $no;
                            echo $no++;
                        } ?>
                    </td>
                    <td>
                        <?php
                        //pengunjung
                        if ($st['periode'] <= 12) {
                            echo number_format($st['st'], 2, ",", ".");
                        } else {
                            echo number_format($pengunjung = $st['st'], 2, ",", ".");
                            $pengunjung_ar[] = $pengunjung;
                        } ?>
                    </td>
                    <td>
                        <?php
                        if ($st['periode'] < 12) {
                            echo number_format(0, 2, ",", ".");
                        } elseif ($st['periode'] == 12) {
                            echo number_format($i_level = $at['a'], 2, ",", ".");
                            $level_ar[] = $i_level;
                        } else {
                            //smoting level (AT-A)
                            echo number_format($i_level = $alfa_a * ($st['st'] - $musim_ar[$smoting]) + (1 - $alfa_a) * ($level_ar[$smoting] + $trend_ar[$smoting]), 2, ",", ".");
                            $level_ar[] = $i_level;
                        } ?>
                    </td>
                    <td>
                        <?php
                        if ($st['periode'] < 12) {
                            echo number_format(0, 2, ",", ".");
                        } elseif ($st['periode'] == 12) {
                            echo number_format($i_trend = $tt['tt'], 2, ",", ".");
                            $trend_ar[] = $i_trend;
                        } else {
                            //smoting trend (TT-A)
                            echo number_format($i_trend = $beta_a * ($i_level - $level_ar[$smoting]) + (1 - $beta_a) * $trend_ar[$smoting], 2, ",", ".");
                            $trend_ar[] = $i_trend;
                        }; ?>
                    </td>
                    <td>
                        <?php
                        if ($st['periode'] <= 12) {
                            //inisialisasi musim (ST-A)
                            echo number_format($i_musim = $st['st'] - $at['a'], 2, ",", ".");
                            $musim_ar[] = $i_musim;
                        } else {
                            //smoting musim (ST-A)
                            echo number_format($i_musim = $gamma_a * ($st['st'] - $i_level) + (1 - $gamma_a) * $musim_ar[$smoting], 2, ",", ".");
                            $musim_ar[] = $i_musim;
                        } ?>
                    </td>
                    <td>
                        <?php
                        if ($st['periode'] > 12) {
                            //prediksi-A
                            echo number_format($i_prediksi = $level_ar[$smoting] + $trend_ar[$smoting] + $musim_ar[$smoting], 2, ",", ".");
                            $prediksi_ar[] = $i_prediksi;
                        } else {
                            //inisialisasi prediksi-A
                            echo number_format(0, 2, ",", ".");
                        } ?>
                    </td>
                    <td>
                        <?php
                        //error-A
                        if ($st['periode'] > 12) {
                            echo number_format($error = $i_prediksi - $st['st'], 2, ",", ".");
                        } else {
                            echo number_format(0, 2, ",", ".");
                        } ?>
                    </td>
                    <td>
                        <?php
                        //abs error-A
                        if ($st['periode'] > 12) {
                            echo number_format($abs = abs($st['st'] - $i_prediksi) / $st['st'], 2, ",", ".");
                            $jumlah_ar[] = $abs;
                        } else {
                            echo number_format(0, 2, ",", ".");
                        } ?>
                    </td>
                    <!--multiplikatif-->
                    <td hidden>
                        <?php
                        if ($st['periode'] < 12) {
                            echo number_format(0, 2, ",", ".");
                        } elseif ($st['periode'] == 12) {
                            echo number_format($i_level_m = $at['a'], 2, ",", ".");
                            $level_m_ar[] = $i_level_m;
                        } else {
                            //smoting level (AT-M)
                            echo number_format($i_level_m = $alfa_m * ($st['st'] / $musim_m_ar[$smoting]) + (1 - $alfa_m) * ($level_m_ar[$smoting] + $trend_m_ar[$smoting]), 2, ",", ".");
                            $level_m_ar[] = $i_level_m;
                        } ?>
                    </td>
                    <td hidden>
                        <?php
                        if ($st['periode'] < 12) {
                            echo number_format(0, 2, ",", ".");
                        } elseif ($st['periode'] == 12) {
                            echo number_format($i_trend_m = $tt['tt'], 2, ",", ".");
                            $trend_m_ar[] = $i_trend_m;
                        } else {
                            //smoting trend (TT-M)
                            echo number_format($i_trend_m = $beta_m * ($i_level_m - $level_m_ar[$smoting]) + (1 - $beta_m) * $trend_m_ar[$smoting], 2, ",", ".");
                            $trend_m_ar[] = $i_trend_m;
                        }; ?>
                    </td>
                    <td hidden>
                        <?php
                        if ($st['periode'] <= 12) {
                            //inisialisasi musim (ST-M)
                            echo number_format($i_musim_m = $st['st'] / $at['a'], 2, ",", ".");
                            $musim_m_ar[] = $i_musim_m;
                        } else {
                            //smoting musim (ST-M)
                            echo number_format($i_musim_m = $gamma_m * ($st['st'] / $i_level_m) + (1 - $gamma_m) * $musim_m_ar[$smoting], 2, ",", ".");
                            $musim_m_ar[] = $i_musim_m;
                        } ?>
                    </td>
                    <td hidden>
                        <?php
                        if ($st['periode'] > 12) {
                            //prediksi-M
                            echo number_format($i_prediksi_m = ($level_m_ar[$smoting] + $trend_m_ar[$smoting]) * $musim_m_ar[$smoting], 2, ",", ".");
                            $prediksi_m_ar[] = $i_prediksi_m;
                            $smoting++;
                        } else {
                            //inisialisasi prediksi-M
                            echo number_format(0, 2, ",", ".");
                        } ?>
                    </td>
                    <td hidden>
                        <?php
                        //error-M
                        if ($st['periode'] > 12) {
                            echo number_format($error_m = $st['st'] - $i_prediksi_m, 2, ",", ".");
                        } else {
                            echo number_format(0, 2, ",", ".");
                        } ?>
                    </td>
                    <td hidden>
                        <?php
                        //abs error-M
                        if ($st['periode'] > 12) {
                            echo number_format($abs_m = abs($error_m) / ((abs($st['st']) + abs($i_prediksi_m)) / 2), 2, ",", ".");
                            $jumlah_m_ar[] = $abs_m;
                        } else {
                            echo number_format(0, 2, ",", ".");
                        } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <br>
    <h3>MAPE : </h3>
    <p>
        = <?php echo number_format($smape_a = (100 / count($jumlah_ar) * array_sum($jumlah_ar)), 2, ",", ".") ?>%
    </p>
    <p hidden>
        Metode Holt-Winter Multiplikatif = <?php echo number_format($smape_m = (100 / count($jumlah_m_ar) * array_sum($jumlah_m_ar)), 2, ",", ".") ?>%
    </p>

    <table border="1">
        <thead>
            <tr>
                <th>NO</th>
                <th>Periode</th>
                <th>Prediksi-A</th>

            </tr>
        </thead>
        <!-- <tfoot>
            <tr>
                <th>NO</th>
                <th>Periode</th>
                <th>Prediksi</th>

            </tr>
        </tfoot> -->
        <tbody>
            <?php
            $periode = $no++;
            $no = 1;
            while ($periode <= ($baris + 12)) {
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $periode; ?></td>
                    <td><?php echo number_format($i_level + $i_trend * ($no) + $musim_ar[($periode) - (1 + 12)], 2, ",", "."); ?></td>
                    <td hidden><?php echo number_format(($i_level_m + $i_trend_m * ($no++)) * $musim_m_ar[($periode++) - (1 + 12)], 2, ",", "."); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>