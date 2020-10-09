<?php 
    include "koneksi.php";
    include "resources/reader/excel_reader2.php";
?>
<div class="row" style="margin-top:10px;">

    <h4>Pengolahan Data</h4>
    <p>CRUD Data Ada Disini</p>
    <div class="col s3">
        <form action="" method="post" enctype="multipart/form-data">
           <div class="file-field input-field">
            <div class="btn blue-grey darken-4">
            <span>File Xls</span>
            <input type="file" name="Ifile" id="" class="" />
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
            </div>
    </div>
    <div class="col s4">
      <br>
    <button class="btn blue-grey darken-3" name="upload" type="submit"><i class="material-icons left">cloud</i>Upload</button>
    </form>
    </div>
    <div class="col s4">
        <!-- Modal Trigger -->
        <form method="POST">
        <button type="Submit" name="bersih" class="btn-floating tooltipped btn-large waves-effect waves-light red right" data-position="bottom" data-tooltip="Hapus Seluruh Data"><i class="material-icons">delete_forever</i></button>
        </form>
        <a style="margin-right:10px;" class="btn-floating tooltipped btn-large waves-effect modal-trigger blue-grey darken-4 right" href="#modal1" data-position="left" data-tooltip="Tambah Data Secara Manual"><i class="material-icons">add</i></a>
      
        <!-- Modal Structure Tambah Manual -->
        <div id="modal1" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4>Input Data Manual</h4>
            <p>Input Data Secara Manual</p>
            <form method="post">
                  <div class="input-field col s12">
                    <input type="text" name="Ikota" id="Kota" class="validate">
                    <label for="Kota">Nama Kota</label>
                  </div>
                  <div class="input-field col s12">
                    <input type="number" name="Isiswa" id="siswa" class="validate">
                    <label for="Siswa">Jumlah Siswa Yang Masuk</label>
                  </div>
                  <div class="input-field col s12">
                    <input type="number" name="Isekolah" id="sekolah" class="validate">
                    <label for="Sekolah" data-error="wrong" data-success="right">Jumlah Sekolah Yang Masuk</label>
                  </div>
                  
                  <div class="input-field col s3">
                    <input type="number" name="Iti" id="sekolah" class="validate">
                    <label for="TI" data-error="wrong" data-success="right">Jumlah Siswa TI</label>
                  </div>

                  <div class="input-field col s3">
                    <input type="number" name="Idkv" id="sekolah" class="validate">
                    <label for="DKV" data-error="wrong" data-success="right">Jumlah Siswa DKV</label>
                  </div>

                  <div class="input-field col s3">
                    <input type="number" name="Ipbm" id="sekolah" class="validate">
                    <label for="TI" data-error="wrong" data-success="right">Jumlah Siswa PBM</label>
                  </div>

                  <div class="input-field col s3">
                    <input type="number" name="Iak" id="sekolah" class="validate">
                    <label for="Akuntansi" data-error="wrong" data-success="right">Jumlah Siswa Akuntansi</label>
                  </div>
                  
                  <div class="input-field col s12">
                    <input type="text" name="Itahun" id="sekolah" class="validate">
                    <label for="Tahun" data-error="wrong" data-success="right">Tahun Data</label>
                  </div>       
          </div>
          <div class="modal-footer">
            <button type="submit" name="kirim" class="btn waves-effect teal">Tambah Data</button>
            </form>
          </div>
        </div>
        </div>
    </div>

   <div class="row">
    <div class="col s12 m8 l11">
    <table class="responsive-table" id="tab">
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
                <th class="center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
          $sql = "SELECT * From tb_data";
          $t = mysqli_query($conn,$sql);
          $no = 1;
          while ($data = mysqli_fetch_array($t)) {
        ?>
            <tr class="center">
                <td><?= $no ?></td>
                <td><?= $data['Kota'] ?></td>
                <td><?= $data['Siswa'] ?></td>
                <td><?= $data['Sekolah'] ?></td>
                <td><?= $data['TI'] ?></td>
                <td><?= $data['DKV'] ?></td>
                <td><?= $data['PBM'] ?></td>
                <td><?= $data['Akuntansi'] ?></td>
                <td><?= $data['Tahun'] ?></td>
                <td><a href="#hapus<?= $data['ID_Data'] ?>" class="waves-effect waves-light btn modal-trigger red"><i class="material-icons">delete</i></a>
                    &nbsp <a href="#edit<?= $data['ID_Data'] ?>" class="waves-effect waves-light btn modal-trigger yellow"><i class="material-icons">edit</i></a>
              </td>
            </tr>

            <!-- Modal Hapus -->
            <div id="hapus<?= $data['ID_Data'] ?>" class="modal bottom-sheet">
              <div class="modal-content">
                <h4>Konfirmasi Hapus Data</h4>
                <p>Apakah anda yakin ingin menghapus Data dari Kota <?= $data['Kota'] ?> di Tahun <?= $data['Tahun'] ?> ? </p>
              </div>
              <div class="modal-footer">
                <form method="POST">
                <input type="hidden" name="Ikode" value="<?= $data['ID_Data'] ?>">
                <button type="submit" name="hapus" class=" modal-action modal-close waves-effect waves-light red btn"><i class="material-icons">delete</i></button>
                </form>
                <a href="#!" class=" modal-action modal-close waves-effect green btn ">Tidak Jadi</a>
              </div>
            </div>
            
            <!-- Modal Structure -->
        <div id="edit<?= $data['ID_Data'] ?>" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4>Halaman Edit Data</h4>
            <p>Edit Data Pada Kota :</p>
            <form method="post">
                  <div class="input-field col s12">
                    <input type="text" name="Ekota" id="Kota" value="<?= $data['Kota'] ?>" class="validate" readonly="true">
                    <label for="Kota">Nama Kota</label>
                  </div>
                  <div class="input-field col s12">
                    <input type="number" name="Esiswa" id="siswa" class="validate">
                    <label for="Siswa">Jumlah Siswa Yang Masuk</label>
                  </div>
                  <div class="input-field col s12">
                    <input type="number" name="Esekolah" id="sekolah" class="validate">
                    <label for="Sekolah" data-error="wrong" data-success="right">Jumlah Sekolah Yang Masuk</label>
                  </div>
                  
                  <div class="input-field col s3">
                    <input type="number" name="Eti" id="sekolah" class="validate">
                    <label for="TI" data-error="wrong" data-success="right">Jumlah Siswa TI</label>
                  </div>

                  <div class="input-field col s3">
                    <input type="number" name="Edkv" id="sekolah" class="validate">
                    <label for="DKV" data-error="wrong" data-success="right">Jumlah Siswa DKV</label>
                  </div>

                  <div class="input-field col s3">
                    <input type="number" name="Epbm" id="sekolah" class="validate">
                    <label for="TI" data-error="wrong" data-success="right">Jumlah Siswa PBM</label>
                  </div>

                  <div class="input-field col s3">
                    <input type="number" name="Eak" id="sekolah" class="validate">
                    <label for="Akuntansi" data-error="wrong" data-success="right">Jumlah Siswa Akuntansi</label>
                  </div>
                  
                  <div class="input-field col s12">
                    <input type="text" name="Etahun" id="sekolah" class="validate">
                    <label for="Tahun" data-error="wrong" data-success="right">Tahun Data</label>
                  </div>       
          </div>
          <div class="fixed-action-btn">
            <input type="hidden" name="Ekode" value="<?= $data['ID_Data'] ?>">
            <button type="submit" name="edit" class="btn btn-floating btn-large waves-effect orange"><i class ="material-icons">edit</i></button>
            </form>
          </div>
          </div>

        <?php
          $no++;
          }
        ?>
        </tbody>
    </table>

    </div>
   </div>


<?php
    if (isset($_POST['kirim'])) {
        $tahun = $_POST['Itahun'];
        $kota = $_POST['Ikota'];
        $siswa = $_POST['Isiswa'];
        $sekolah = $_POST['Isekolah'];
        $ti = $_POST['Iti'];
        $dkv = $_POST['Idkv'];
        $pbm = $_POST['Ipbm'];
        $ak = $_POST['Iak'];
        
        $sql = "insert into tb_data(Kota,Siswa,Sekolah,TI,DKV,PBM,Akuntansi,Tahun) 
        values('$kota','$siswa','$sekolah','$ti','$dkv','$pbm','$ak','$tahun')";
        $try = mysqli_query($conn,$sql);
        if ($try) { 
        echo "<script> M.toast({html: '<i class=material-icons>done</i> Data $kota Tahun $tahun Telah Terinput', classes:'rounded green'}) </script>";
        ?>
        <script> setTimeout("location.href = '?p=data';" ,1500); </script>
      <?php
      }
    }

    if (isset($_POST['upload'])) {
      $files = "resources/assets/".basename($_FILES['Ifile']['name']);
      move_uploaded_file($_FILES['Ifile']['tmp_name'],$files);

      chmod("resources/assets/".$_FILES['Ifile']['name'],0777);
      $data = new Spreadsheet_Excel_Reader($files);
      $baris = $data->rowcount($sheet_index = 0);
      
      //cek berapa baris
      // print_r($baris);

      for ($i=2; $i <= $baris; $i++) { 
        $kota = $data->val($i, 1);
        $siswa = $data->val($i, 2);
        $sekolah = $data->val($i, 3);
        $ti = $data->val($i, 4);
        $dkv = $data->val($i, 5); 
        $pbm = $data->val($i, 6); 
        $ak = $data->val($i, 7);
        $tahun = $data->val($i, 8);

        $sql = "insert into tb_data(Kota,Siswa,Sekolah,TI,DKV,PBM,Akuntansi,Tahun) 
        values('$kota','$siswa','$sekolah','$ti','$dkv','$pbm','$ak','$tahun')";
        $try = mysqli_query($conn,$sql);
        if ($try) { }
      }
      echo" <script> M.toast({html: '<i class=material-icons>done_all</i> File Telah Terupload', classes:'rounded green'}) </script>";
      ?> <script> setTimeout("location.href = '?p=data';" ,1500); </script>
    <?php
    }

    if (isset($_POST['edit'])) {
      $tahun = $_POST['Etahun'];
      $kota = $_POST['Ekota'];
      $siswa = $_POST['Esiswa'];
      $sekolah = $_POST['Esekolah'];
      $ti = $_POST['Eti'];
      $dkv = $_POST['Edkv'];
      $pbm = $_POST['Epbm'];
      $ak = $_POST['Eak'];
      $kode = $_POST['Ekode'];

      $sql = "UPDATE tb_data SET Kota = '$kota', Siswa = '$siswa', Sekolah = '$sekolah', TI = '$ti'
      , DKV = '$dkv', PBM = '$pbm', Akuntansi = '$ak', Tahun = '$tahun' where ID_Data = '$kode' ";
      $c = mysqli_query($conn,$sql);

      if($c) {
        echo "<script> M.toast({html: '<i class=material-icons>done</i> Data $kota Tahun $tahun Berhasil Dirubah', classes:'rounded green'}) </script>";
        ?>
        <script> setTimeout("location.href = '?p=data';" ,1500); </script>
      <?php
      }else{
        echo "<script> M.toast({html: '<i class=material-icons>done</i> Data $kota Tahun $tahun Gagal Dirubah', classes:'rounded red'}) </script>";
      }

    }

    if (isset($_POST['hapus'])) {
      $kode = $_POST['Ikode'];
      $sql = "DELETE FROM tb_data Where ID_Data = '$kode' ";
      $h = mysqli_query($conn,$sql);

      if($h) {
        echo "<script> M.toast({html: '<i class=material-icons>done</i> Data Berhasil Dihapus', classes:'rounded green'}) </script>";
        ?>
        <script> setTimeout("location.href = '?p=data';" ,1500); </script>
      <?php
      }else{
        echo "<script> M.toast({html: '<i class=material-icons>done</i> Data Gagal Dihapus', classes:'rounded red'}) </script>";
      }
    }

    if (isset($_POST['bersih'])) {
      
      $sql ="TRUNCATE tb_data";
      $be = mysqli_query($conn,$sql);

      if ($be) {
        echo "<script> M.toast({html: '<i class=material-icons>done</i> Seluruh File Dihapus', classes:'rounded red'}) </script>";
      }

    }

?>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function(){
    $('.modal').modal();
    $('.tooltipped').tooltip();
    $('#tab').DataTable();
  });
</script>