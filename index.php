<!DOCTYPE html>
<html lang="en">
<head>
 <?php
  if (empty($_GET['p'])) {
    $_GET['p'] = "home";
  }
 ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= "Laman Admin - ".$_GET['p']; ?></title>
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="js/chart/Chart.min.css">

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="js/materialize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>

    <!-- Navbar -->
    <header id="header" class="page-topbar">
    <nav>
        <div class="nav-wrapper blue-grey darken-4">
        <a href="#" data-target="mobile-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right">
        <li><a class='dropdown-trigger tooltipped' href='#' data-position="left" data-tooltip="Control Panel" data-target='pilihmenu'><i class="material-icons">settings</i></a></li>
        </ul>

        <ul id='pilihmenu' class='dropdown-content blue-grey darken-4'>
        <li><a class="white-text" href="#"><i class="white-text material-icons">lock</i>Logout</a></li>
        <li><a class="white-text" href="#"><i class="white-text material-icons">info</i>Something Else ?</a></li>
        </ul>
        </div>
    </nav>
    </header>

   

    <!-- Content -->
    <div id="main">
    <div class="row">
    <div class="col s12 m4 l3">
    <ul class="sidenav sidenav-collapsible leftside-navigation sidenav-fixed  blue-grey darken-4" id="mobile-menu">
        <li> 
            <div class="user-view">
                <div class="background brand-logo">
                <img src="images/cover.jpg" />
                </div>
                <a href="#user"><img class="circle" src="images/logo.jpg"></a>
                <a href="#name"><span class="white-text name">Institut Teknologi Dan Bisnis Asia Malang</span></a>
                <a href="#email"><span class="white-text email">Jl. Soekarno - Hatta,Kota Malang, Jawa Timur 65113</span></a>
            </div>
        </li>
        <li><a class="white-text" href="?p=data">Menejemen Data</a></li>
        <li><a class="white-text" href="?p=perhitunganC3">Perhitungan</a></li>
        <li><a class="white-text" href="?p=hasilC3">Lihat Hasil Data</a></li>
    </ul>
    </div>
    <div class="col s12 m12 l9">
       
           <?php
                $p_dir ="pages";
                if (!empty($_GET['p'])) {
                    $pages = scandir($p_dir, 0);
                    unset($pages[0], $pages[1]);
        
                    $p = $_GET['p'];
                    if (in_array($p.'.php', $pages)) {
                        include($p_dir.'/'.$p.'.php');
                    } else{
                        ?>
                        <div class="nodim">
                        <h2>ERROR 404</h2>
                        <h4>Laman Kamu Cari Masih Belum Tersedia :'((</h4>
                        </div>
                        <?php
                    }
                } else {
                    include($p_dir.'/home.php');
                }
           ?>
        </div>
        </div>
            </div>
    </div>
    
</body>

<footer class="page-footer blue-grey darken-4">
    <div>
        <div class="row">
            <div class="right">
                <h5 class="white-text" style="text-align:right;">Project Tugas Akhir &nbsp&nbsp&nbsp</h5>
                <p class="grey-text text-lighten-4" style="text-align:right;">Klasterisasi Daerah Mahasiswa Baru Berpotensi Masuk &nbsp&nbsp&nbsp&nbsp <br> Di Institut Teknologi Dan Bisnis Asia Dengan Menggunakan Metode K-Means. &nbsp&nbsp&nbsp&nbsp</p>
                <a class="grey-text text-lighten-4 right" href="#!" style="text-align:right;" > © <?= date("Y") ?> Muchammad Rifny Setyawan &nbsp&nbsp&nbsp&nbsp</a>
            </div>
        </div>
    </div>
 
</footer>

<!-- script -->
<script>
  $(document).ready(function(){
    $('.sidenav').sidenav();
    $('.tooltipped').tooltip();
    $('.dropdown-trigger').dropdown();
  });
</script>
</html>