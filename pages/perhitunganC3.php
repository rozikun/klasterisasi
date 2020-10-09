<?php include 'koneksi.php'; ?>
<h4>Halaman Perhitungan</h4>
<div class="row centered">
<form method="post">
     <div class="input-field col s12">
     <select name="Itahun">
        <option value="" disabled selected>Pilih Tahun</option>
        <?php
            $sql = "select distinct(Tahun) from tb_data";
            $cari = mysqli_query($conn,$sql);
            while ($c = mysqli_fetch_array($cari)) {
        ?>
        <option value="<?= $c[0] ?>"><?= $c[0] ?></option>
        <?php
         }
        ?>
     </select>
     <label for="">Perhitungan Pada Tahun: </label>
     </div>
         <div class="input-field col s4">
            <select name="centro1">
                <option value="Malang" disabled selected>Kota pertama</option>
                <?php
                    $sql = "SELECT distinct(Kota) from tb_data";
                    $lakon = mysqli_query($conn,$sql);
                    $id_no = 0;
                    while($data = mysqli_fetch_array($lakon)){
                ?>
                    <option value="<?= $id_no ?>"><?= $data['Kota'] ?></option>
                <?php
                    $id_no++;
                    }
                ?>
            </select>
         <label for="">Centroid Pertama</label>
         </div>

         <div class="input-field col s4">
            <select name="centro2">
                <option value="Malang" disabled selected>Kota Kedua</option>
                <?php
                    $sql = "SELECT distinct(Kota) from tb_data";
                    $lakon = mysqli_query($conn,$sql);
                    $id_no = 0;
                    while($data = mysqli_fetch_array($lakon)){
                ?>
                    <option value="<?= $id_no ?>"><?= $data['Kota'] ?></option>
                <?php
                    $id_no++;
                    }
                ?>
            </select>
         <label for="">Centroid Kedua</label>
         </div>

         <div class="input-field col s4">
            <select name="centro3">
                <option value="Malang" disabled selected>Kota Ketiga</option>
                <?php
                    $sql = "SELECT distinct(Kota) from tb_data";
                    $lakon = mysqli_query($conn,$sql);
                    $id_no = 0;
                    while($data = mysqli_fetch_array($lakon)){
                ?>
                    <option value="<?= $id_no ?>"><?= $data['Kota'] ?></option>
                <?php
                    $id_no++;
                    }
                ?>
            </select>
         <label for="">Centroid Ketiga</label>
         </div>
     <div class="col s12">
     <button type="submit" name="hitung" class="waves-effect waves-light blue-grey darken-4 btn">Mulai Perhitungan</button>
     </div>
</form>
</div>
<?php
    if (isset($_POST['hitung'])) {
        //deklarasi variable
        $tahun = $_POST['Itahun'];
        $siswa = array();
        $sekolah = array();
        $ti = array();
        $dkv = array();
        $pbm = array();
        $ak = array();

        //pemanggilan data pencarian
        $kota1 = $_POST['centro1'];
        $kota2 = $_POST['centro2'];
        $kota3 = $_POST['centro3'];

        //pencarian data awal untuk preprocessing
        $sql = "SELECT * FROM tb_data Where Tahun = '$tahun' ";
        $h = mysqli_query($conn,$sql);

        $sql_siswa = "select AVG(Siswa) from tb_data where Tahun = '$tahun'";
        $sql_sekolah = "select AVG(Sekolah) from tb_data where Tahun = '$tahun'";
        $sql_TI = "select AVG(TI) from tb_data where Tahun = '$tahun'";
        $sql_DKV = "select AVG(DKV) from tb_data where Tahun = '$tahun'";
        $sql_PBM = "select AVG(PBM) from tb_data where Tahun = '$tahun'";
        $sql_AK = "select AVG(Akuntansi) from tb_data where Tahun = '$tahun'";
        
        //rata-rata semua nilai
        //siswa
        $rs =  mysqli_query($conn,$sql_siswa);
        if ($a = mysqli_fetch_array($rs)) {
         $rsiswa = $a[0];    
        }
        //sekolah
        $rse =  mysqli_query($conn,$sql_sekolah);
        if ($a = mysqli_fetch_array($rse)) {
         $rsekolah = $a[0]; 
        }

        //TI
        $rst =  mysqli_query($conn,$sql_TI);
        if ($a = mysqli_fetch_array($rst)) {
         $rti = $a[0]; 
        }
        //DKV
        $rsd =  mysqli_query($conn,$sql_DKV);
        if ($a = mysqli_fetch_array($rsd)) {
         $rdkv = $a[0]; 
        }
        //PBM
        $rsp =  mysqli_query($conn,$sql_PBM);
        if ($a = mysqli_fetch_array($rsp)) {
         $rpbm = $a[0]; 
        }
        //AKUNTANSI
        $rsa =  mysqli_query($conn,$sql_AK);
        if ($a = mysqli_fetch_array($rsa)) {
         $rak = $a[0];
        }

        //membuat stdev
        $i = 0;
        $sqlse ="SELECT * From tb_data where Tahun = '$tahun' ";
        $w = mysqli_query($conn,$sqlse);
        while ($data = mysqli_fetch_array($w)) {
            $siswa[$i]   = $data['Siswa'];            
            $sekolah[$i] = $data['Sekolah'];
            $ti[$i]      = $data['TI'];
            $dkv[$i]     = $data['DKV'];
            $pbm[$i]     = $data['PBM'];
            $ak[$i]      = $data['Akuntansi'];
            $i++;
        }
        
        //Perhitungan Deviasi Siswa
        $Ssiswa = pow($siswa[0]-$rsiswa,2) + pow($siswa[1]-$rsiswa,2);
        for ($i=2; $i < count($siswa); $i++) { 
            $Ssiswa = $Ssiswa + pow($siswa[$i]-$rsiswa,2);
        }
        $DevSiswa = round(sqrt( $Ssiswa / (count($siswa)-1) ), 9 );
        
        //Perhitungan Deviasi Sekolah
        $Ssekolah = pow($sekolah[0]-$rsekolah,2) + pow($sekolah[1]-$rsekolah,2);
        for ($i=2; $i < count($sekolah); $i++) { 
            $Ssekolah = $Ssekolah + pow($sekolah[$i]-$rsekolah,2);
        }
        $DevSekolah = round(sqrt( $Ssekolah / (count($sekolah)-1) ), 9 );
        
        //Perhitungan Deviasi TI
        $Ssti = pow($ti[0]-$rti,2) + pow($ti[1]-$rti,2);
        for ($i=2; $i < count($ti); $i++) { 
            $Ssti = $Ssti + pow($ti[$i]-$rti,2);
        }
        $DevTi = round(sqrt( $Ssti / (count($ti)-1) ), 9 );
        
        //Perhitungan Deviasi DKV
        $Sdkv = pow($dkv[0]-$rdkv,2) + pow($dkv[1]-$rdkv,2);
        for ($i=2; $i < count($dkv); $i++) { 
            $Sdkv = $Sdkv + pow($dkv[$i]-$rdkv,2);
        }
        $DevDkv = round(sqrt( $Sdkv / (count($dkv)-1) ), 9 );

        //Perhitungan Deviasi PBM
        $Spbm = pow($pbm[0]-$rpbm,2) + pow($pbm[1]-$rpbm,2);
        for ($i=2; $i < count($pbm); $i++) { 
            $Spbm = $Spbm + pow($pbm[$i]-$rpbm,2);
        }
        $DevPbm = round(sqrt( $Spbm / (count($pbm)-1) ), 9 );
        
        //Perhitungan Deviasi Akuntansi
        $Sak = pow($ak[0]-$rak,2) + pow($ak[1]-$rak,2);
        for ($i=2; $i < count($ak); $i++) { 
            $Sak = $Sak + pow($ak[$i]-$rak,2);
        }
        $DevAk = round(sqrt( $Sak / (count($ak)-1) ), 9 );
        
?>
<div class="col s12">
<table class="centered" id="tab">
    <thead class="white-text teal">
        <tr>
            <th>Kota</th>
            <th>C1</th>
            <th>C2</th>
            <th>C3</th>
            <th>Klaster</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // echo $rsekolah." ".$DevSekolah; 1,3,5
    echo "Tahun Yang Dipilih : ".$tahun;
    $zSiswa = array();
    $zSekolah = array();
    $zTI = array();
    $zDKV = array();
    $zPBM = array();
    $zAK = array();
    $c1 = array();
    $c2 = array();
    $c3 = array();
    $klaster = array();
    $klasterb = array();
    $k1s = array(); $k1se = array(); $k1ti = array(); $k1dkv = array(); $k1pbm = array(); $k1ak = array();
    $k2s = array(); $k2se = array(); $k2ti = array(); $k2dkv = array(); $k2pbm = array(); $k2ak = array();
    $k3s = array(); $k3se = array(); $k3ti = array(); $k3dkv = array(); $k3pbm = array(); $k3ak = array();

    $k = 0;
        while ($data = mysqli_fetch_array($h)){
            $kota[$k] = $data['Kota'];
            $zSiswa[$k] = round( ( $data['Siswa'] - $rsiswa ) / $DevSiswa, 9 );
            $zSekolah[$k] = round( ( $data['Sekolah'] - $rsekolah ) / $DevSekolah, 9 );
            $zTI[$k] = round( ( $data['TI'] - $rti ) / $DevTi, 9 );
            $zDKV[$k] = round( ( $data['DKV'] - $rdkv ) / $DevDkv, 9 );
            $zPBM[$k] = round( ( $data['PBM'] - $rpbm ) / $DevPbm, 9 );
            $zAK[$k] = round( ( $data['Akuntansi'] - $rak ) / $DevAk, 9 );
            $k++;
        }
            //klasterisasi iterasi 1 dan perhitungan centroid baru (Awal : Malang,Banyuwangi,Bekasi)
            for ($i=0; $i < count($kota) ; $i++) { 
                $c1[$i] = sqrt(pow($zSiswa[$i]-$zSiswa[$kota1], 2 ) + pow($zSekolah[$i] - $zSekolah[$kota1], 2) + pow($zTI[$i] - $zTI[$kota1], 2) + pow($zDKV[$i] - $zDKV[$kota1], 2) + pow($zPBM[$i] - $zPBM[$kota1], 2) + pow($zAK[$i] - $zAK[$kota1], 2) );
                $c2[$i] = sqrt(pow($zSiswa[$i]-$zSiswa[$kota2], 2 ) + pow($zSekolah[$i] - $zSekolah[$kota2], 2) + pow($zTI[$i] - $zTI[$kota2], 2) + pow($zDKV[$i] - $zDKV[$kota2], 2) + pow($zPBM[$i] - $zPBM[$kota2], 2) + pow($zAK[$i] - $zAK[$kota2], 2) );
                $c3[$i] = sqrt(pow($zSiswa[$i]-$zSiswa[$kota3], 2 ) + pow($zSekolah[$i] - $zSekolah[$kota3], 2) + pow($zTI[$i] - $zTI[$kota3], 2) + pow($zDKV[$i] - $zDKV[$kota3], 2) + pow($zPBM[$i] - $zPBM[$kota3], 2) + pow($zAK[$i] - $zAK[$kota3], 2) );
                if ($c1[$i] < $c2[$i] && $c1[$i] < $c3[$i]) {
                    $klaster[$i] = 1;
                    array_push($k1s,$zSiswa[$i]);
                    array_push($k1se,$zSekolah[$i]);
                    array_push($k1ti,$zTI[$i]);
                    array_push($k1dkv,$zDKV[$i]);
                    array_push($k1pbm,$zPBM[$i]);
                    array_push($k1ak,$zAK[$i]);
                }elseif($c2[$i] < $c1[$i] && $c2[$i] < $c3[$i]){
                    $klaster[$i] = 2;
                    array_push($k2s,$zSiswa[$i]);
                    array_push($k2se,$zSekolah[$i]);
                    array_push($k2ti,$zTI[$i]);
                    array_push($k2dkv,$zDKV[$i]);
                    array_push($k2pbm,$zPBM[$i]);
                    array_push($k2ak,$zAK[$i]);
                }else{
                    $klaster[$i] = 3;
                    array_push($k3s,$zSiswa[$i]);
                    array_push($k3se,$zSekolah[$i]);
                    array_push($k3ti,$zTI[$i]);
                    array_push($k3dkv,$zDKV[$i]);
                    array_push($k3pbm,$zPBM[$i]);
                    array_push($k3ak,$zAK[$i]);
                }
           
    ?>
        <tr>
            <td class="left"><?= $kota[$i] ?></td>
            <td><?= $c1[$i] ?></td>
            <td><?= $c2[$i] ?></td>
            <td><?= $c3[$i] ?></td>
            <td><?= $klaster[$i] ?></td>
        </tr>
    <?php
         }
         //penentuan centroid baru untuk iterasi 2 dan selanjutnya
         $CentroSiswa[0] =  array_sum($k1s) / count($k1s);
         $CentroSiswa[1] =  array_sum($k2s) / count($k2s);
         $CentroSiswa[2] =  array_sum($k3s) / count($k3s);
         $CentroSekolah[0] = array_sum($k1se) / count($k1se);
         $CentroSekolah[1] = array_sum($k2se) / count($k2se);
         $CentroSekolah[2] = array_sum($k3se) / count($k3se);
         $CentroTi[0] = array_sum($k1ti) / count($k1ti);
         $CentroTi[1] = array_sum($k2ti) / count($k2ti);
         $CentroTi[2] = array_sum($k3ti) / count($k3ti);
         $CentroDkv[0] = array_sum($k1dkv) / count($k1dkv);
         $CentroDkv[1] = array_sum($k2dkv) / count($k2dkv);
         $CentroDkv[2] = array_sum($k3dkv) / count($k3dkv);
         $CentroPbm[0] = array_sum($k1pbm) / count($k1pbm);
         $CentroPbm[1] = array_sum($k2pbm) / count($k2pbm);
         $CentroPbm[2] = array_sum($k3pbm) / count($k3pbm);
         $CentroAk[0] = array_sum($k1ak) / count($k1ak);
         $CentroAk[1] = array_sum($k2ak) / count($k2ak);
         $CentroAk[2] = array_sum($k3ak) / count($k3ak);
    ?>
    </tbody>
</table>

<p>Iterasi Ke 2 dan Selanjutnya Hingga didapat Klaster yang sama</p>
<!-- Perulangan dari sini -->
<?php 
    $mula = 2;
   
     do {
        //reset untuk perhitungan centroid baru
     unset($k1s); unset($k1se); unset($k1ti); unset($k1dkv); unset($k1pbm); unset($k1ak);
     unset($k2s); unset($k2se); unset($k2ti); unset($k2dkv); unset($k2pbm); unset($k2ak);
     unset($k3s); unset($k3se); unset($k3ti); unset($k3dkv); unset($k3pbm); unset($k3ak);
     unset($validasi);
     $k1s = array(); $k1se = array(); $k1ti = array(); $k1dkv = array(); $k1pbm = array(); $k1ak = array();
     $k2s = array(); $k2se = array(); $k2ti = array(); $k2dkv = array(); $k2pbm = array(); $k2ak = array();
     $k3s = array(); $k3se = array(); $k3ti = array(); $k3dkv = array(); $k3pbm = array(); $k3ak = array();

     echo "<p>Iterasi Ke : ".$mula."</p>";
?>

<table class="centered responsive" id="tab<?= $mula ?>"> 
         <thead class="blue-grey darken-4 white-text">
            <tr>
            <th>Kota</th>
            <th>C1</th>
            <th>C2</th>
            <th>C3</th>
            <th>Klaster</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $validasi = array();
            for ($i=0; $i < count($kota) ; $i++) { 
                $c1[$i] = round(sqrt(pow($zSiswa[$i]-$CentroSiswa[0], 2 ) + pow($zSekolah[$i] - $CentroSekolah[0], 2) + pow($zTI[$i] - $CentroTi[0], 2) + pow($zDKV[$i] - $CentroDkv[0], 2) + pow($zPBM[$i] - $CentroPbm[0], 2) + pow($zAK[$i] - $CentroAk[0], 2) ), 10);
                $c2[$i] = round(sqrt(pow($zSiswa[$i]-$CentroSiswa[1], 2 ) + pow($zSekolah[$i] - $CentroSekolah[1], 2) + pow($zTI[$i] - $CentroTi[1], 2) + pow($zDKV[$i] - $CentroDkv[1], 2) + pow($zPBM[$i] - $CentroPbm[1], 2) + pow($zAK[$i] - $CentroAk[1], 2) ), 10);
                $c3[$i] = round(sqrt(pow($zSiswa[$i]-$CentroSiswa[2], 2 ) + pow($zSekolah[$i] - $CentroSekolah[2], 2) + pow($zTI[$i] - $CentroTi[2], 2) + pow($zDKV[$i] - $CentroDkv[2], 2) + pow($zPBM[$i] - $CentroPbm[2], 2) + pow($zAK[$i] - $CentroAk[2], 2) ), 10);
                if ($c1[$i] < $c2[$i] && $c1[$i] < $c3[$i]) {
                    $klasterb[$i] = 1;
                    array_push($k1s,$zSiswa[$i]);
                    array_push($k1se,$zSekolah[$i]);
                    array_push($k1ti,$zTI[$i]);
                    array_push($k1dkv,$zDKV[$i]);
                    array_push($k1pbm,$zPBM[$i]);
                    array_push($k1ak,$zAK[$i]);
                }elseif($c2[$i] < $c1[$i] && $c2[$i] < $c3[$i]){
                    $klasterb[$i] = 2;
                    array_push($k2s,$zSiswa[$i]);
                    array_push($k2se,$zSekolah[$i]);
                    array_push($k2ti,$zTI[$i]);
                    array_push($k2dkv,$zDKV[$i]);
                    array_push($k2pbm,$zPBM[$i]);
                    array_push($k2ak,$zAK[$i]);
                }else{
                    $klasterb[$i] = 3;
                    array_push($k3s,$zSiswa[$i]);
                    array_push($k3se,$zSekolah[$i]);
                    array_push($k3ti,$zTI[$i]);
                    array_push($k3dkv,$zDKV[$i]);
                    array_push($k3pbm,$zPBM[$i]);
                    array_push($k3ak,$zAK[$i]);
                }

                if ($klaster[$i] == $klasterb[$i]) {
                    array_push($validasi,"Sama");
                }else{
                    array_push($validasi,"Berbeda");
                    $klaster[$i] = $klasterb[$i];
                }
        ?>
                <tr>
                    <td class="left"><?= $kota[$i] ?></td>
                    <td><?= $c1[$i] ?></td>
                    <td><?= $c2[$i] ?></td>
                    <td><?= $c3[$i] ?></td>
                    <td><?= $klasterb[$i] ?></td>
                </tr>
        <?php
            }
            ?>
         </tbody>
         <?php  echo "<span>Jumlah Klaster Sama : ". array_count_values($validasi)['Sama']."</span>" ?>
         <?php print_r(array_count_values($klaster)); ?>
</table>

<?php

    //penentuan centroid baru untuk iterasi 2 dan selanjutnya
         $CentroSiswa[0] =  array_sum($k1s) / count($k1s);
         $CentroSiswa[1] =  array_sum($k2s) / count($k2s);
         $CentroSiswa[2] =  array_sum($k3s) / count($k3s);
         $CentroSekolah[0] = array_sum($k1se) / count($k1se);
         $CentroSekolah[1] = array_sum($k2se) / count($k2se);
         $CentroSekolah[2] = array_sum($k3se) / count($k3se);
         $CentroTi[0] = array_sum($k1ti) / count($k1ti);
         $CentroTi[1] = array_sum($k2ti) / count($k2ti);
         $CentroTi[2] = array_sum($k3ti) / count($k3ti);
         $CentroDkv[0] = array_sum($k1dkv) / count($k1dkv);
         $CentroDkv[1] = array_sum($k2dkv) / count($k2dkv);
         $CentroDkv[2] = array_sum($k3dkv) / count($k3dkv);
         $CentroPbm[0] = array_sum($k1pbm) / count($k1pbm);
         $CentroPbm[1] = array_sum($k2pbm) / count($k2pbm);
         $CentroPbm[2] = array_sum($k3pbm) / count($k3pbm);
         $CentroAk[0] = array_sum($k1ak) / count($k1ak);
         $CentroAk[1] = array_sum($k2ak) / count($k2ak);
         $CentroAk[2] = array_sum($k3ak) / count($k3ak);

//pengulangan angka
    $mula++;
     }while(array_count_values($validasi)['Sama'] != count($kota) );

     //  Memasukan Hasil Ke Database
    $sqlc = "Select * From tb_hasil_c3 where Tahun = $tahun ";
    $cari = mysqli_query($conn,$sqlc);
    if (mysqli_num_rows($cari) > 1) {
            $sqlt = "DELETE from tb_hasil_c3 where Tahun = $tahun ";
            $hap = mysqli_query($conn,$sqlt);
            if ($hap) { }
    }
     for ($i=0; $i < count($kota) ; $i++) { 
         $sql = "INSERT into tb_hasil_c3(Kota,C1_AKhir,C2_Akhir,C3_Akhir,Klaster,Tahun)  Values('$kota[$i]', '$c1[$i]','$c2[$i]','$c3[$i]','$klasterb[$i]','$tahun')";
         $t = mysqli_query($conn,$sql);

     if ($t) { /* Sudah Selesai Ditambahkan */ }
     }

   //Proses Perhitungan DBI Evaluation
    //Pencarian SSW1
    for ($i=0; $i < count($k1s); $i++) { 
        $sw1[$i] = round(pow($k1s[$i]-$CentroSiswa[0], 2 ) + pow($k1se[$i] - $CentroSekolah[0], 2) + pow($k1ti[$i] - $CentroTi[0], 2) + pow($k1dkv[$i] - $CentroDkv[0], 2) + pow($k1pbm[$i] - $CentroPbm[0], 2) + pow($k1ak[$i] - $CentroAk[0], 2 ), 9);
    }
    $ssw1 = array_sum($sw1) / count($sw1);
  
    //Pencarian SSW2
    for ($i=0; $i < count($k2s); $i++) { 
        $sw2[$i] = round(pow($k2s[$i]-$CentroSiswa[1], 2 ) + pow($k2se[$i] - $CentroSekolah[1], 2) + pow($k2ti[$i] - $CentroTi[1], 2) + pow($k2dkv[$i] - $CentroDkv[1], 2) + pow($k2pbm[$i] - $CentroPbm[1], 2) + pow($k2ak[$i] - $CentroAk[1], 2 ), 9);
    }
    $ssw2 = array_sum($sw2) / count($sw2);
    
    //Pencarian SSW3
    for ($i=0; $i < count($k3s); $i++) { 
        $sw3[$i] = round(pow($k3s[$i]-$CentroSiswa[2], 2 ) + pow($k3se[$i] - $CentroSekolah[2], 2) + pow($k3ti[$i] - $CentroTi[2], 2) + pow($k3dkv[$i] - $CentroDkv[2], 2) + pow($k3pbm[$i] - $CentroPbm[2], 2) + pow($k3ak[$i] - $CentroAk[2], 2  ), 9);
    }
    $ssw3 = array_sum($sw3) / count($sw3);

    // Pencarian SSB 
    // $ssb = sqrt(( pow($CentroSiswa[0] - $CentroSiswa[1] - $CentroSiswa[2] ,2) ) + ( pow( $CentroSekolah[0] - $CentroSekolah[1] - $CentroSekolah[2] ,2) ) + ( pow($CentroTi[0] - $CentroTi[1] - $CentroTi[2], 2) ) + ( pow($CentroDkv[0] - $CentroDkv[1] - $CentroDkv[2],2)) + ( pow($CentroPbm[0] - $CentroPbm[1] - $CentroPbm[2],2)) + ( pow($CentroAk[0] - $CentroAk[1] - $CentroAk[2],2) ));

    $ssb1 = abs( ($CentroSiswa[0] - $CentroSiswa[1]) + (  $CentroSekolah[0] - $CentroSekolah[1])  + ($CentroTi[0] - $CentroTi[1])  + ($CentroDkv[0] - $CentroDkv[1]) + ( $CentroPbm[0] - $CentroPbm[1] ) + ($CentroAk[0] - $CentroAk[1] ) );
    $ssb2 = abs( ($CentroSiswa[0] - $CentroSiswa[2]) + (  $CentroSekolah[0] - $CentroSekolah[2])  + ($CentroTi[0] - $CentroTi[2])  + ($CentroDkv[0] - $CentroDkv[2]) + ( $CentroPbm[0] - $CentroPbm[2] ) + ($CentroAk[0] - $CentroAk[2] ) );
    $ssb3 = abs( ($CentroSiswa[1] - $CentroSiswa[2]) + (  $CentroSekolah[1] - $CentroSekolah[2])  + ($CentroTi[1] - $CentroTi[2])  + ($CentroDkv[1] - $CentroDkv[2]) + ( $CentroPbm[1] - $CentroPbm[2] ) + ($CentroAk[1] - $CentroAk[2] ) );

    
    //pencarian Rasio (Bisa Dijadikan nilai DBI karena C=2 ?)
    // $ratio = round( ($ssw1 + $ssw2 + $ssw3) / $ssb,8 );
    
    $rab = ($ssw1 + $ssw2) / $ssb1;
    $rac = ($ssw1 + $ssw3) / $ssb2;
    $rbc = ($ssw2 + $ssw3) / $ssb3;
    
    //check erroring Data
    // echo $ssw1.'<br>'.$ssw2;
    // echo '<br>'.array_sum($sw2);;
    
    
    //Dmax (experimental)
    $dmax1 = max($rab,$rac);
    $dmax2 = max($rab,$rbc);
    $dmax3 = max($rac,$rbc);

    //DBI
    $dbi = ($dmax1+$dmax2+$dmax3)/3;
?>

    <div class="card teal">
        <div class="card-content white-text">
            <span class="card-tittle">Hasil Evaluasi DBI Pada Klaster C=3</span>
            <h4>Evaluasi DBI : </h4>
            <p>Nilai SSW1 : <?= $ssw1 ?> Nilai SSW2 : <?= $ssw2 ?> Nilai SSW3 : <?= $ssw3 ?></p>
            <p>Nilai SSB1 : <?= $ssb1 ?> Nilai SSB2 : <?= $ssb2 ?> Nilai SSB3 : <?= $ssb3 ?></p>
            <p>DBI experimental : <?= $dbi ?></p>
        </div>
    </div>
<?php

    //penambahan data evaluasi ke database
    $sqlc = "Select * From tb_eval_c3 where Tahun = $tahun ";
    $cari = mysqli_query($conn,$sqlc);
    if (mysqli_num_rows($cari) > 1) {
            $sqlt = "DELETE from tb_eval_c3 where Tahun = $tahun ";
            $hap = mysqli_query($conn,$sqlt);
    if ($hap) { /* Sudah Terhapus */ }
    }

    $sql = "INSERT into tb_eval_c3(Tahun,SSW1,SSW2,SSW3,SSB,DBI) Values('$tahun','$ssw1','$ssw2','$ssw3','$ssb1','$dbi') ";
    $ev = mysqli_query($conn,$sql);
    if ($ev) {
        # Sudah Ditambahkan
    }
    //akhir isset

    ?>
    <script> M.toast({html: '<i class=material-icons>done</i> Perhitungan Selesai Dilakukan Pada Iterasi Ke : <?= $mula - 1 ?>', classes:'rounded green'}) </script>
<?php

}
?>
</div>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
    $(document).ready(function() {
        $('#tab').DataTable({
            "searching": false
        });
        for (let index = 1; index < <?php if (empty($mula)) { $mula = 0; echo $mula; } else echo $mula; ?>; index++) {
            $('#tab'+index).DataTable({
                "searching": false
            });
        } 
    });
</script>
