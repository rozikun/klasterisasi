<?php
    include "koneksi.php";
?>
    <h3>Penampil Hasil Untuk C=3</h3>
    <form action="" method="POST">
        <h5>Tahun Perbandingan</h5>
        <div class="row">
            <div class="col s5 m5">
                <p>Dari :</p>
                <select name="Itahun1" required="true">
                <option value="" disabled selected>Pilih Tahun</option>
                    <?php
                        $sql = "SELECT distinct(Tahun) from tb_eval_c3 order by  Tahun ";
                        $opsi = mysqli_query($conn,$sql);
                        while($data = mysqli_fetch_array($opsi)){
                    ?>
                        <option value="<?= $data['Tahun'] ?>"> <?= $data['Tahun'] ?> </option>        
                    <?php
                        }
                    ?>
                </select>
        </div>
            <div class="col s5 m5">
                <p>Ke : </p>
                <select name="Itahun2" required="true">
                <option value="" disabled selected>Pilih Tahun</option>
                    <?php
                        $sql = "SELECT distinct(Tahun) from tb_eval_c3 order by  Tahun ";
                        $opsi = mysqli_query($conn,$sql);
                        while($data = mysqli_fetch_array($opsi)){
                    ?>
                        <option value="<?= $data['Tahun'] ?>"> <?= $data['Tahun'] ?> </option>        
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <div>
        <button class="btn waves-effect teal darken-4 pill" type="submit" name="action">Tampilkan
            <i class="material-icons right">search</i>
        </button>
    </form>
<!-- Hasil Pencarian -->
<?php
    if (isset($_POST['action'])) {
        ?>
     <!-- Modal Trigger -->
    <a class="waves-effect waves-light btn modal-trigger" href="#modal1">   <i class="material-icons right">date_range</i> Lihat Data Perbandingan Secara Detail</a>   
    </div>

    <div class="card white lighten-4">
            <div class="card-content">
                <span class="card-title">Grafik Kesimpulan</span>
                <canvas id="grafik" ></canvas>
    </div>
    </div>
    
    <div class="row">
    <?php
        echo "Rekap Data Pertahun :<br>";
        $nilai1 = $_POST['Itahun1'];
        $nilai2 = $_POST['Itahun2'];
        
        $hdata1 = array();
        $hdata2 = array();
        $hdata3 = array();

        $max = abs($nilai2 - $nilai1) + 1;
        
        if ($nilai1 < $nilai2) {
            $kecil = $nilai1;
            $besar = $nilai2;
        }else{
            $kecil = $nilai2;
            $besar = $nilai1;
        }

        for ($i=0; $i < $max; $i++) {
            $sql1 = "SELECT * From tb_eval_c3 Where Tahun = '$kecil' ";
            $sql2 = "SELECT tb_data.Kota,tb_data.Siswa,tb_hasil_c3.Klaster From tb_data inner join tb_hasil_c3 on tb_data.Kota = tb_hasil_c3.Kota and tb_data.Tahun = tb_hasil_c3.Tahun where tb_hasil_c3.Klaster = 1 and tb_data.Tahun = '$kecil' order by tb_data.Siswa DESC";
            $sql3 = "SELECT tb_data.Kota,tb_data.Siswa,tb_hasil_c3.Klaster From tb_data inner join tb_hasil_c3 on tb_data.Kota = tb_hasil_c3.Kota and tb_data.Tahun = tb_hasil_c3.Tahun where tb_hasil_c3.Klaster = 2 and tb_data.Tahun = '$kecil' order by tb_data.Siswa DESC";
            $sql4 = "SELECT tb_data.Kota,tb_data.Siswa,tb_hasil_c3.Klaster From tb_data inner join tb_hasil_c3 on tb_data.Kota = tb_hasil_c3.Kota and tb_data.Tahun = tb_hasil_c3.Tahun where tb_hasil_c3.Klaster = 3 and tb_data.Tahun = '$kecil' order by tb_data.Siswa DESC";

            $sql5 = "SELECT count(Klaster) from tb_hasil_c3 where Klaster = 1 and Tahun = $kecil ";
            $sql6 = "SELECT count(Klaster) from tb_hasil_c3 where Klaster = 2 and Tahun = $kecil ";
            $sql7 = "SELECT count(Klaster) from tb_hasil_c3 where Klaster = 3 and Tahun = $kecil ";

            $calper = mysqli_query($conn,$sql1);

            $calmax1 = mysqli_query($conn,$sql2);
            $calmax2 = mysqli_query($conn,$sql3);
            $calmax3 = mysqli_query($conn,$sql4);
            
            $hasil  = mysqli_fetch_array($calper);
            $hasil2 = mysqli_fetch_array($calmax1);
            $hasil3 = mysqli_fetch_array($calmax2);
            $hasil4 = mysqli_fetch_array($calmax3);

            $data1 = mysqli_fetch_array(mysqli_query($conn,$sql5));
            $data2 = mysqli_fetch_array(mysqli_query($conn,$sql6));
            $data3 = mysqli_fetch_array(mysqli_query($conn,$sql7));

             //perbandingan tiap tahun
             array_push($hdata1,$data1[0]);
             array_push($hdata2,$data2[0]);
             array_push($hdata3,$data3[0]);
             
        ?>
        <!-- Manggil Data -->
        <div class="col m6">
             <div class="card blue-grey darken-4">
                <div class="card-content white-text">
                    <span class="card-title">Tahun <?= $kecil ?></span>
                    <p>Hasil DBI : <?= $hasil['DBI'] ?></p>
                    <p>Klaster 1 Terbesar : <?= $hasil2['Kota'] ?> (Jumlah Siswa : <?= $hasil2['Siswa'] ?> )</p>
                    <p>Klaster 2 Terbesar : <?= $hasil3['Kota'] ?> (Jumlah Siswa : <?= $hasil3['Siswa'] ?> )</p>
                    <p>Klaster 3 Terbesar : <?= $hasil4['Kota'] ?> (Jumlah Siswa : <?= $hasil4['Siswa'] ?> )</p>
                </div>
                <div class="card-action">
                <canvas class="white" id="myChart<?= $kecil ?>"></canvas>
                    <script>
                    var ctx = document.getElementById("myChart<?= $kecil ?>").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["Banyak Anggota Klaster Pada Tahun <?= $kecil ?> "],
                            datasets: [{
                                label: 'Klaster 1',
                                data: [<?= $data1[0] ?>],
                                backgroundColor: [
                                'rgba(255, 99, 132)',
                                'rgba(54, 162, 235)',
                                ],
                                borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                ],
                                borderWidth: 1
                            },{
                                label: 'Klaster 2',
                                data: [<?= $data2[0] ?>],
                                backgroundColor: [
                                'rgba(54, 162, 235)',
                                ],
                                borderColor: [
                                'rgba(54, 162, 235, 1)',
                                ],
                                borderWidth: 1 
                            },{
                                label: 'Klaster 3',
                                data: [<?= $data3[0] ?> ],
                                backgroundColor: [
                                'rgba(28, 128, 0, 1)',
                                ],
                                borderColor: [
                                'rgba(28, 128, 0, 1)',
                                ],
                                borderWidth: 1 
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <?php
            $kecil++;    
        }   

        $kecil = $kecil - $max;
        // Tampilkan Grafik Simpulan 
        ?>
        </div>
        
       
                <script  type="text/javascript">
                var ctx = document.getElementById("grafik").getContext("2d");
                var data = {
                            labels: [<?php for($i = 0; $i < $max ; $i++ ){  ?> "<?= $kecil ?>", <?php $kecil++; } ?> ],
                            datasets: [
                            {
                            label: "Kluster 1",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(255, 99, 132)",
                            borderColor: "rgba(255, 99, 132)",
                            pointHoverBackgroundColor: "rgba(255, 99, 132)",
                                        pointHoverBorderColor: "rgba(255, 99, 132)",
                            data:  [<?php for($i = 0; $i < $max ; $i++ ){  ?> <?= $hdata1[$i] ?>, <?php } ?> ]
                            },
                        {
                            label: "Kluster 2",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(54, 162, 235)",
                            borderColor: "rgba(54, 162, 235)",
                            pointHoverBackgroundColor: "rgba(54, 162, 235)",
                                        pointHoverBorderColor: "rgba(54, 162, 235)",
                            data: [<?php for($i = 0; $i < $max ; $i++ ){  ?> <?= $hdata2[$i] ?>, <?php } ?> ]
                            },
                        {
                            label: "Kluster 3",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(28, 128, 0, 1)",
                            borderColor: "rgba(28, 128, 0, 1)",
                            pointHoverBackgroundColor: "rgba(28, 128, 0, 1)",
                                        pointHoverBorderColor: "rgba(28, 128, 0, 1)",
                            data: [<?php for($i = 0; $i < $max ; $i++ ){  ?> <?= $hdata3[$i] ?>, <?php } ?> ]
                            }
                            ]
                            };

                var myBarChart = new Chart(ctx, {
                            type: 'line',
                            data: data,
                            options: {
                            barValueSpacing: 1,
                            scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                }
                            }],
                            xAxes: [{
                                        gridLines: {
                                            color: "rgba(0, 0, 0, 0)",
                                        }
                                    }]
                            }
                        }
                        });
                </script>

        <!-- Export PDF Disini -->
        <form action="" method="POST">
            <input type="hidden" name="Inilai1" value="<?= $nilai1 ?>">
            <input type="hidden" name="Inilai2" value="<?= $nilai2 ?>">
        </form>
        <?php
    }
?>
</div>

<!-- Modal Nye -->
<!-- Modal Structure -->
<div id="modal1" class="modal">
<div class="modal-content">
    <h4>Detail Perbandingan</h4>
    <p>Data Perbandingan Dari <?= $nilai1 ?> Hingga <?= $nilai2 ?></p>
    
    <div class="">
    <table class="responsive-table" id="tab1">
        <thead class="blue-grey darken-4 white-text">
            <tr>
                <th class="center">No</th>
                <th class="center">Kota</th>
                <th class="center">Siswa</th>
                <th class="center">Sekolah</th>
                <th class="center">TI</th>
                <th class="center">DKV</th>
                <th class="center">PBM</th>
                <th class="center">AK</th>
                <th class="center">Tahun</th>
                <th class="center">Klaster</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $penomoran = 1;
            $sqlx  = "SELECT tb_data.Kota,tb_data.Siswa,tb_data.Sekolah,tb_data.TI,tb_data.DKV,tb_data.PBM,tb_data.Akuntansi,tb_data.Tahun,tb_hasil_c3.Klaster From tb_data inner join tb_hasil_c3 on tb_data.Kota = tb_hasil_c3.Kota and tb_data.Tahun = tb_hasil_c3.Tahun where tb_data.Tahun <= '$besar' order by tb_data.Tahun ASC ";
            $baca = mysqli_query($conn,$sqlx);

            while ($data = mysqli_fetch_array($baca)) {
        ?>
            <tr>
            <td><?= $penomoran ?></td>
            <td><?= $data['Kota']  ?></td>
            <td><?= $data['Siswa']  ?></td>
            <td><?= $data['Sekolah']  ?></td>
            <td><?= $data['TI']  ?></td>
            <td><?= $data['DKV']  ?></td>
            <td><?= $data['PBM']  ?></td>
            <td><?= $data['Akuntansi']  ?></td>
            <td><?= $data['Tahun']  ?></td>
            <td><?= $data['Klaster']  ?></td>
            </tr>
        <?php
            $penomoran++;
             }
        ?>
        </tbody>
    </table>
    </div>
</div>
<div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Tutup</a>
</div>
</div>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function(){
    $('select').formSelect();
  });
$(document).ready(function(){
    $('.modal').modal();
  });
$('.tooltipped').tooltip();
$('#tab1').DataTable();
</script>
