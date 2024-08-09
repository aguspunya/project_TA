<?php
// file proses_data.php merupakan halaman untuk menangani request Ajax baik untuk proses tambah, ubah, maupun hapus
// respon balikan dari masing-masing proses tersebut adalah dalam format JSON.

include_once "config.php";

//fungsi untuk men-generate ID pelanggan, ex: P0001
function buatID($tabel, $inisial){
    $struktur = mysql_query("select * from $tabel") or die("query tidak dapat dijalankan!");
    $field = mysql_field_name($struktur,0);
    $panjang = mysql_field_len($struktur,0);
    $row = mysql_num_rows($struktur);
    $panjanginisial = strlen($inisial);
    $awal = $panjanginisial + 1;
    $bnyk = $panjang-$panjanginisial;

    if ($row >= 1){
      	$query = mysql_query("select max(substring($field,$awal,$bnyk)) as max from $tabel") or die("query tidak dapat dijalankan!");
      	$hasil = mysql_fetch_assoc($query);
      	$angka = intval($hasil['max']);
    } else {
      	$angka = 0;
    }
 
    $angka++;
    $tmp= "";
    for ($i=0; $i < ($panjang-$panjanginisial-strlen($angka)) ; $i++){
      	$tmp = $tmp."0";
    }
    //return hasil generate ID
    return strval($inisial.$tmp.$angka);
}

if(isset($_POST['action']) && $_POST['action'] == "add") {
	$tgl = $_POST['tglbeli'];
	$idvend = $_POST['cbVend'];
	$kdbrg = $_POST['cbBarang'];
	$qty = $_POST['qty'];
	$nobuk = buatID("beli","B-");
	mysql_query("INSERT INTO beli(NoBukti,TglBeli,IdVendor,KdBarang,Qty) VALUES ('$nobuk','$tgl','$idvend','$kdbrg','$qty')") or die ("Data gagal ditambahkan!");
	mysql_query("UPDATE barang SET Stok = Stok - '$qty' where KdBarang='$kdbrg'");
	// mengembalikan respon dalam format JSON.
    // status "1" berarti proses berhasil dilakukan.
	echo '{"status":"1"}';
	exit;
}
elseif(isset($_POST['action']) && $_POST['action'] == "update") {
	$nobuk = $_POST['nobukti'];
	$tgl = $_POST['tglbeli'];
	$idvend = $_POST['cbVend'];
	$kdbrg = $_POST['cbBarang'];
	$qty = $_POST['qty'];
	$str = mysql_query("SELECT * FROM beli WHERE NoBukti='$nobuk'") or die ("Gagal pilih No Bukti!");
	$data = mysql_fetch_array($str);
	$jml = $data['qty'];
	$jum = $jml-$qty;
	$hs = mysql_query("UPDATE barang SET Stok = Stok + '$jum' WHERE KdBarang='$kdbrg'");
	$test = mysql_query("UPDATE beli SET TglBeli='$tgl', IdVendor='$idvend', KdBarang='$kdbrg', Qty='$qty' WHERE NoBukti='$nobuk'") or die ("Data gagal di update!");
	echo '{"status":"1"}';
	exit;
}
elseif(isset($_GET['action']) && $_GET['action'] == "delete") {
	$id = $_GET['no'];
	$str = mysql_query("SELECT * FROM beli WHERE NoBukti='$id'") or die ("Gagal pilih No Bukti!");
	$data = mysql_fetch_array($str);
	$kdbrg = $data['KdBarang'];
	$jml = $data['Qty'];
	$hs = mysql_query("UPDATE barang SET Stok = Stok + '$jml' WHERE KdBarang='$kdbrg'");
	$test = mysql_query("DELETE FROM beli WHERE NoBukti='$id'");
	if(mysql_affected_rows() == 1) {
		echo '{"status":"1"}';
	} else {
		echo '{"status":"0"}';
	}
	exit;
}
else if(isset($_POST['action']) && $_POST['action'] == "addvend") {
	$nama = $_POST['namavendor'];
	$alamat = $_POST['alamat'];
	$kota = $_POST['kota'];
	$telp = $_POST['telp'];
	$email = $_POST['email'];
	$idvend = buatID("vendor","V-");
	mysql_query("INSERT INTO vendor(IdVendor,Nama,Alamat,Kota,Telp,Email) VALUES ('$idvend','$nama','$alamat','$kota','$telp','$email')") or die ("Data gagal ditambahkan!");
	// mengembalikan respon dalam format JSON.
    // status "1" berarti proses berhasil dilakukan.
	echo '{"status":"1"}';
	exit;
}
else if(isset($_POST['action']) && $_POST['action'] == "addbrg") {
$nama = $_POST['namabarang'];
	$harga = $_POST['harga'];
	$stok = $_POST['stok'];
	$stokmin = $_POST['stokmin'];
	$kdbrg = buatID("barang","KB");
	mysql_query("INSERT INTO barang(KdBarang,NmBarang,Harga,Stok,StokMinimum) VALUES ('$kdbrg','$nama','$harga','$stok','$stokmin')") or die ("Data gagal ditambahkan!");
	// mengembalikan respon dalam format JSON.
    // status "1" berarti proses berhasil dilakukan.
	echo '{"status":"1"}';
	exit;
}
?>