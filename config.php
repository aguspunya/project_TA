<?php
$mysql_hostname = "localhost";  //alamat server
$mysql_user = "root";       //username untuk koneksi ke database
$mysql_password = "";   //password koneksi ke database, klo tidak ada bisa dikosongkan
$mysql_database = "php_03";   //nama database yang akan diakses/digunakan
mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Koneksi ke database gagal!");
mysql_select_db($mysql_database) or die("Database tidak ditemukan!");

?>
