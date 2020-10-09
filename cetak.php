<?php
include 'koneksi.php';
if (empty($_POST['Kirim1']) && empty($_POST['Kirim2']) ) {
    echo "Kosong";
    $nilai1 = 0;
    $nilai2 = 0;
}else{
    $nilai1 = $_POST['Kirim1'];
    $nilai2 = $_POST['Kirim2'];
}
$no = 1;

//perulangan untuk membuat halaman
$max = abs($nilai2 - $nilai1) + 1;
        
if ($nilai1 < $nilai2) {
    $kecil = $nilai1;
}else{
    $kecil = $nilai2;
}

require_once('resources/dompdf/autoload.inc.php');
use Dompdf\Dompdf;
    $dompdf = new Dompdf();
//mulai mencetak
    $html ='<html>
            <head>
            <title>Hasil Clustering $nilai1 - $nilai2 </title>
            <link rel="stylesheet" href="css/materialize.min.css">
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="js/chart/Chart.min.css">
            </head>
    ';
    //Body HTML
    $html .= '
        <div class="center" align="center"> 
               <h5> Hasil Clustering Untuk Tahun '.$nilai1.' Hingga '.$nilai2.' <h5>
        </div>
    ';
//perulangan
for ($i=0; $i < $max; $i++) { 
    $html .='
        <small> Tahun : '.$kecil.' </small>
        <table class="table"> 
        <thead class="blue-grey darken-4 white-text">
            <tr>
                <th>No</th>
                <th>Kota</th>
                <th>Siswa</th>
                <th>Sekolah</th>
                <th>TI</th>
                <th>DKV</th>
                <th>PBM</th>
                <th>AK</th>
                <th>Cluster</th>
            </tr>
        </thead>
        <tbody>
    ';
    $sql  = "SELECT tb_data.Kota,tb_data.Siswa,tb_data.Sekolah,tb_data.TI,tb_data.DKV,tb_data.PBM,tb_data.Akuntansi,tb_hasil_c2.Klaster From tb_data inner join tb_hasil_c2 on tb_data.Kota = tb_hasil_c2.Kota and tb_data.Tahun = tb_hasil_c2.Tahun where tb_hasil_c2.Tahun = '2015' ";
    $coba = mysqli_query($conn,$sql);
    while($data = mysqli_fetch_array($coba)){
        $html.='<tr>
                <td>'. $no .'</td>
                <td>'.$data['Kota'].'</td>
                <td>'.$data['Siswa'].' </td>
                <td>'.$data['Sekolah'].' </td>
                <td>'.$data['TI'].' </td>
                <td>'.$data['DKV'].' </td>
                <td>'.$data['PBM'].' </td>
                <td>'.$data['Akuntansi'].' </td>
                <td>'.$data['Klaster'].' </td>
                </tr>
        ';
    $no++;
    }
    $html .='
        </tbody>
        </table>
    ';

    $sql2 = "SELECT count(Klaster) from tb_hasil_c2 where Klaster = 1 and Tahun = $nilai1 ";
    $sql3 = "SELECT count(Klaster) from tb_hasil_c2 where Klaster = 2 and Tahun = $nilai1 ";
    $sql4 = "SELECT * From tb_eval_c2 Where Tahun = '$nilai1' ";
    $sql5 = "SELECT tb_data.Kota,tb_data.Siswa,tb_hasil_c2.Klaster From tb_data inner join tb_hasil_c2 on tb_data.Kota = tb_hasil_c2.Kota and tb_data.Tahun = tb_hasil_c2.Tahun where tb_hasil_c2.Klaster = 1 and tb_data.Tahun = '$nilai1' order by tb_data.Siswa DESC";
    $sql6 = "SELECT tb_data.Kota,tb_data.Siswa,tb_hasil_c2.Klaster From tb_data inner join tb_hasil_c2 on tb_data.Kota = tb_hasil_c2.Kota and tb_data.Tahun = tb_hasil_c2.Tahun where tb_hasil_c2.Klaster = 2 and tb_data.Tahun = '$nilai1' order by tb_data.Siswa DESC";
    
    $con1 = mysqli_fetch_array(mysqli_query($conn, $sql2));
    $con2 = mysqli_fetch_array(mysqli_query($conn, $sql3));
    $con3 = mysqli_fetch_array(mysqli_query($conn, $sql4));

    $hasil2 = mysqli_fetch_array(mysqli_query($conn, $sql5));
    $hasil3 = mysqli_fetch_array(mysqli_query($conn, $sql6));
    $html .='
         <div class="card blue-grey darken-4">
                <div class="card-content white-text">
                    <p>Klaster 1 Sebanyak : '.$con1[0].'</p>
                    <p>Klaster 2 Sebanyak : '.$con2[0].'</p>
                    <p>Klaster 1 Terbesar :  '.$hasil2['Kota'].'  (Jumlah Siswa :  '.$hasil2['Siswa'].')</p>
                    <p>Klaster 2 Terbesar :  '.$hasil3['Kota'].'  (Jumlah Siswa :  '.$hasil3['Siswa'].')</p>
                    <p>Hasil DBI : '.$con3['DBI'].'</p>
                </div>
            </div>
            <div class="page_break"></div>
    ';
 $kecil++;
}   
    //penutup
    $html .= "</html>";
    $dompdf->loadHtml($html);
    // Setting ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'potrait');
    // Rendering dari HTML Ke PDF
    $dompdf->render();
    // Melakukan output file Pdf
    $dompdf->stream('Hasil Clustering '.$nilai1.' - '.$nilai2.' .pdf');
?>
