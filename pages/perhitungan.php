<?php include 'koneksi.php'; ?>
<h4>Halaman Perhitungan</h4>
<div class="row centered">
<form method="post">
     <div class="input-field col s4">
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
     <select name="Ikota1">
        <option value="" disabled selected>Pilih Kota</option>
        <?php
            $sql = "select distinct(Kota) from tb_data";
            $cari = mysqli_query($conn,$sql);
            $ko = 0;
            while ($c = mysqli_fetch_array($cari)) {
        ?>
        <option value="<?= $ko ?>"><?= $c[0] ?></option>
        <?php
            $ko++;
         }
        ?>
     </select>
     <label for="">Centroid Kota Pertama: </label>
     </div>

     <div class="input-field col s4">
     <select name="Ikota2">
        <option value="" disabled selected>Pilih Kota</option>
        <?php
            $sql = "select distinct(Kota) from tb_data";
            $cari = mysqli_query($conn,$sql);
            $ko2 = 0;
            while ($c = mysqli_fetch_array($cari)) {
        ?>
        <option value="<?= $ko2 ?>"><?= $c[0] ?></option>
        <?php
            $ko2++;
         }
        ?>
     </select>
     <label for="">Centroid Kota Kedua: </label>
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

        //deklarasi khusus pemanggilan data pencarian
        $skota1 = $_POST['Ikota1'];
        $skota2 = $_POST['Ikota2'];

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
<table class="centered">
    <thead class="white-text teal">
        <tr>
            <th>Kota</th>
            <th>C1</th>
            <th>C2</th>
            <th>Klaster</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // echo $rsekolah." ".$DevSekolah; 1,3
    echo "Tahun Yang Dipilih : ".$tahun;
    $zSiswa = array();
    $zSekolah = array();
    $zTI = array();
    $zDKV = array();
    $zPBM = array();
    $zAK = array();
    $c1 = array();
    $c2 = array();
    $klaster = array();
    $klasterb = array();
    $k1s = array(); $k1se = array(); $k1ti = array(); $k1dkv = array(); $k1pbm = array(); $k1ak = array();
    $k2s = array(); $k2se = array(); $k2ti = array(); $k2dkv = array(); $k2pbm = array(); $k2ak = array();
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
            //klasterisasi iterasi 1 dan perhitungan centroid baru (Awal : 1,3)
            for ($i=0; $i < count($kota) ; $i++) { 
                $c1[$i] = sqrt(pow($zSiswa[$i]-$zSiswa[$skota1], 2 ) + pow($zSekolah[$i] - $zSekolah[$skota1], 2) + pow($zTI[$i] - $zTI[$skota1], 2) + pow($zDKV[$i] - $zDKV[$skota1], 2) + pow($zPBM[$i] - $zPBM[$skota1], 2) + pow($zAK[$i] - $zAK[$skota1], 2) );
                $c2[$i] = sqrt(pow($zSiswa[$i]-$zSiswa[$skota2], 2 ) + pow($zSekolah[$i] - $zSekolah[$skota2], 2) + pow($zTI[$i] - $zTI[$skota2], 2) + pow($zDKV[$i] - $zDKV[$skota2], 2) + pow($zPBM[$i] - $zPBM[$skota2], 2) + pow($zAK[$i] - $zAK[$skota2], 2) );
            
                if ($c1[$i] < $c2[$i]) {
                    $klaster[$i] = 1;
                    array_push($k1s,$zSiswa[$i]);
                    array_push($k1se,$zSekolah[$i]);
                    array_push($k1ti,$zTI[$i]);
                    array_push($k1dkv,$zDKV[$i]);
                    array_push($k1pbm,$zPBM[$i]);
                    array_push($k1ak,$zAK[$i]);
                }else{
                    $klaster[$i] = 2;
                    array_push($k2s,$zSiswa[$i]);
                    array_push($k2se,$zSekolah[$i]);
                    array_push($k2ti,$zTI[$i]);
                    array_push($k2dkv,$zDKV[$i]);
                    array_push($k2pbm,$zPBM[$i]);
                    array_push($k2ak,$zAK[$i]);
                }
           
    ?>
        <tr>
            <td class="left"><?= $kota[$i] ?></td>
            <td><?= $c1[$i] ?></td>
            <td><?= $c2[$i] ?></td>
            <td><?= $klaster[$i] ?></td>
        </tr>
    <?php
         }
         //penentuan centroid baru untuk iterasi 2 dan selanjutnya
         $CentroSiswa[0] =  round( array_sum($k1s) / count($k1s), 9);
         $CentroSiswa[1] =  round( array_sum($k2s) / count($k2s), 9);
         $CentroSekolah[0] = round( array_sum($k1se) / count($k1se), 9);
         $CentroSekolah[1] = round( array_sum($k2se) / count($k2se), 9);
         $CentroTi[0] = round(array_sum($k1ti) / count($k1ti), 9);
         $CentroTi[1] = round(array_sum($k2ti) / count($k2ti), 9);
         $CentroDkv[0] = round(array_sum($k1dkv) / count($k1dkv), 9);
         $CentroDkv[1] = round(array_sum($k2dkv) / count($k2dkv), 9);
         $CentroPbm[0] = round(array_sum($k1pbm) / count($k1pbm),9);
         $CentroPbm[1] = round(array_sum($k2pbm) / count($k2pbm), 9);
         $CentroAk[0] = round(array_sum($k1ak) / count($k1ak),9);
         $CentroAk[1] = round(array_sum($k2ak) / count($k2ak), 9);
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
     unset($validasi);
     $k1s = array(); $k1se = array(); $k1ti = array(); $k1dkv = array(); $k1pbm = array(); $k1ak = array();
     $k2s = array(); $k2se = array(); $k2ti = array(); $k2dkv = array(); $k2pbm = array(); $k2ak = array();
     echo "Iterasi Ke : ".$mula;
?>

<table class="centered responsive"> 
         <thead class="blue-grey darken-4 white-text">
            <tr>
            <th>Kota</th>
            <th>C1</th>
            <th>C2</th>
            <th>Klaster</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $validasi = array();
            for ($i=0; $i < count($kota) ; $i++) { 
                $c1[$i] = round(sqrt(pow($zSiswa[$i]-$CentroSiswa[0], 2 ) + pow($zSekolah[$i] - $CentroSekolah[0], 2) + pow($zTI[$i] - $CentroTi[0], 2) + pow($zDKV[$i] - $CentroDkv[0], 2) + pow($zPBM[$i] - $CentroPbm[0], 2) + pow($zAK[$i] - $CentroAk[0], 2) ), 10);
                $c2[$i] = round(sqrt(pow($zSiswa[$i]-$CentroSiswa[1], 2 ) + pow($zSekolah[$i] - $CentroSekolah[1], 2) + pow($zTI[$i] - $CentroTi[1], 2) + pow($zDKV[$i] - $CentroDkv[1], 2) + pow($zPBM[$i] - $CentroPbm[1], 2) + pow($zAK[$i] - $CentroAk[1], 2) ), 10);
            
                if ($c1[$i] < $c2[$i]) {
                    $klasterb[$i] = 1;
                    array_push($k1s,$zSiswa[$i]);
                    array_push($k1se,$zSekolah[$i]);
                    array_push($k1ti,$zTI[$i]);
                    array_push($k1dkv,$zDKV[$i]);
                    array_push($k1pbm,$zPBM[$i]);
                    array_push($k1ak,$zAK[$i]);
                }else{
                    $klasterb[$i] = 2;
                    array_push($k2s,$zSiswa[$i]);
                    array_push($k2se,$zSekolah[$i]);
                    array_push($k2ti,$zTI[$i]);
                    array_push($k2dkv,$zDKV[$i]);
                    array_push($k2pbm,$zPBM[$i]);
                    array_push($k2ak,$zAK[$i]);
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
                    <td><?= $klasterb[$i] ?></td>
                </tr>
        <?php
            }
            ?>
         </tbody>
         <?php  echo "<br>Jumlah Klaster Sama : ". array_count_values($validasi)['Sama']."<br>" ?>
         <?php print_r(array_count_values($klaster)); ?>
</table>

<?php

    //penentuan centroid baru untuk iterasi 2 dan selanjutnya
         $CentroSiswa[0] = round( array_sum($k1s) / count($k1s), 10);
         $CentroSiswa[1] = round( array_sum($k2s) / count($k2s), 10);
         $CentroSekolah[0] =round( array_sum($k1se) / count($k1se), 10);
         $CentroSekolah[1] =round( array_sum($k2se) / count($k2se), 10);
         $CentroTi[0] =round( array_sum($k1ti) / count($k1ti), 10);
         $CentroTi[1] =round( array_sum($k2ti) / count($k2ti), 10);
         $CentroDkv[0] =round( array_sum($k1dkv) / count($k1dkv), 10);
         $CentroDkv[1] =round( array_sum($k2dkv) / count($k2dkv), 10);
         $CentroPbm[0] =round( array_sum($k1pbm) / count($k1pbm), 10);
         $CentroPbm[1] =round( array_sum($k2pbm) / count($k2pbm), 10);
         $CentroAk[0] =round( array_sum($k1ak) / count($k1ak), 10);
         $CentroAk[1] =round( array_sum($k2ak) / count($k2ak), 10);

//pengulangan angka
    $mula++;
    }while(array_count_values($validasi)['Sama'] != count($kota) );

    //  Memasukan Hasil Ke Database
    $sqlc = "Select * From tb_hasil_c2 where Tahun = $tahun ";
    $cari = mysqli_query($conn,$sqlc);
    if (mysqli_num_rows($cari) > 1) {
            $sqlt = "DELETE from tb_hasil_c2 where Tahun = $tahun ";
            $hap = mysqli_query($conn,$sqlt);
            if ($hap) { }
    }
     for ($i=0; $i < count($kota) ; $i++) { 
         $sql = "INSERT into tb_hasil_c2(Kota,C1_AKhir,C2_Akhir,Klaster,Tahun)  Values('$kota[$i]', '$c1[$i]','$c2[$i]','$klasterb[$i]','$tahun')";
         $t = mysqli_query($conn,$sql);

     if ($t) { /* Sudah Selesai Ditambahkan */ }
     }
?>
<?php

//Proses Evaluasi
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
        
        // Pencarian SSB 
        $ssb = abs(( $CentroSiswa[0] - $CentroSiswa[1])  + ( $CentroSekolah[0] - $CentroSekolah[1] )  + ($CentroTi[0] - $CentroTi[1])  + ($CentroDkv[0] - $CentroDkv[1]) + ( $CentroPbm[0] - $CentroPbm[1]) + ($CentroAk[0] - $CentroAk[1]) );

        //pencarian Rasio (Bisa Dijadikan nilai DBI karena C=2 ?)
        $ratio = round( ($ssw1 + $ssw2) / $ssb,8 );
?>

        <div class="card teal">
            <div class="card-content white-text">
                <span class="card-tittle">Hasil Evaluasi DBI Pada Klaster C=2</span>
                <h4>Evaluasi DBI : </h4>
                <p>Nilai SSW1 : <?= $ssw1 ?> Nilai SSW2 : <?= $ssw2 ?></p>
                <p>Nilai SSB : <?= $ssb ?></p>
                <p>DBI Didapat : <?= $ratio ?></p>
            </div>
        </div>
<?php
    //penambahan data evaluasi ke database
    $sqlc = "Select * From tb_eval_c2 where Tahun = $tahun ";
    $cari = mysqli_query($conn,$sqlc);
    if (mysqli_num_rows($cari) > 1) {
            $sqlt = "DELETE from tb_eval_c2 where Tahun = $tahun ";
            $hap = mysqli_query($conn,$sqlt);
    if ($hap) { /* Sudah Terhapus */ }
    }

    $sql = "INSERT into tb_eval_c2(Tahun,SSW1,SSW2,SSB,DBI) Values('$tahun','$ssw1','$ssw2','$ssb','$ratio') ";
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
<script>
     $('select').formSelect();
</script>