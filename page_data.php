<script type="text/javascript">
// fungsi ini untuk menampilkan list data pelanggan sesuai halaman (page) yang dipilih.
// list data yang ditampilkan disesuaikan juga dengan input data pada bagian search.
function pagination(page) {
	var cari = $("input#fieldcari").val();
	var combo = $("select#pilihcari").val();
	
	if(combo == "nobukti") {
		dataString = 'starting='+page+'&no='+cari+'&random='+Math.random();
	}
	else if(combo == "idvendor") {
		dataString = 'starting='+page+'&id='+cari+'&random='+Math.random();
	}	
	else if(combo == "nmvendor") {
		dataString = 'starting='+page+'&vend='+cari+'&random='+Math.random();
	}
	else if(combo == "kdbarang") {
		dataString = 'starting='+page+'&kd='+cari+'&random='+Math.random();
	}
	else if(combo == "nmbarang") {
		dataString = 'starting='+page+'&brg='+cari+'&random='+Math.random();
	}
	else{
    	dataString = 'starting='+page+'&random='+Math.random();
 	}
	
	$.ajax({
		url: "page_data.php",
		data: dataString,
		type: "GET",
		success: function(data) {
			$("#divPageData").html(data);
		}
	});
}

// fungsi untuk me-load tampilan list data pelanggan, data yang ditampilkan disesuaikan
// juga dengan input data pada bagian search
function loadData() {
	var dataString;
	var cari = $("input#fieldcari").val();
	var combo = $("select#pilihcari").val();
			
	if(combo == "nobukti") {
		dataString = 'no='+ cari;
	} else if (combo == "idvendor") {
		dataString = 'id='+ cari;
	} else if (combo == "nmvendor") {
		dataString = 'vend='+ cari;
	} else if (combo == "kdbarang") {
		dataString = 'kd='+ cari;
	} else if (combo == "nmbarang") {
		dataString = 'brg='+ cari;
	}
			
	$.ajax({
		url: "page_data.php",
		type: "GET",
		data: dataString,
		success: function(data) {
			$('#divPageData').html(data);
		}
	});
}

$(function() {
	// membuat warna tampilan baris data pada tabel menjadi selang-seling
  	$('#tblpembelian tr:even:not(#nav):not(#total)').addClass('even');
  	$('#tblpembelian tr:odd:not(#nav):not(#total)').addClass('odd');
	
	$("a.edit").click(function(){
    	page=$(this).attr("href");
    	$("#divFormContent").load(page); // me-load formpembelian untuk melakukan edit data
    	$("#divFormContent").show();
    	$("#btnhide").show();
    	return false;
 	});
 
  	$("a.delete").click(function(){
    	if(confirm("Apakah benar akan menghapus data pembelian ini?")){
        	$.ajax({
          		url:$(this).attr("href"),
          		type:"GET",
          		dataType: 'json', //respon yang diminta dalam format JSON
          		success:function(response){
             		if(response.status == 1){
                  		loadData();
                  		$("#divFormContent").load("formpembelian.php");
                  		$("#divFormContent").hide();
                  		$("#btnhide").hide();
                  		alert("Data berhasil di hapus!");
             		} else {
                  		alert("Data gagal di hapus!");
             		}
          		}
        	});
    	}
    	return false;
  	});
});
</script>

<?php
// memanfaatkan class pagination dari Reneesh T.K
include_once('config.php');
include_once('pagination_class.php');

if(isset($_GET['no']) and !empty($_GET['no'])) {
	$nobuk = $_GET['no'];
	$sql = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang WHERE beli.NoBukti like '%$nobuk%' ORDER BY beli.NoBukti";
}
else if(isset($_GET['id']) and !empty($_GET['id'])) {
	$idvend = $_GET['id'];
	$sql = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang WHERE beli.NoBukti like '%$idvend%' ORDER BY beli.NoBukti";
}
else if(isset($_GET['vend']) and !empty($_GET['vend'])) {
	$vendor = $_GET['vend'];
	$sql = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang WHERE beli.NoBukti like '%$vendor%' ORDER BY beli.NoBukti";
}
else if(isset($_GET['kd']) and !empty($_GET['kd'])) {
	$kdbrg = $_GET['kd'];
	$sql = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang WHERE beli.NoBukti like '%$kdbrg%' ORDER BY beli.NoBukti";
}
else if(isset($_GET['brg']) and !empty($_GET['brg'])) {
	$barang = $_GET['brg'];
	$sql = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang WHERE beli.NoBukti like '%$barang%' ORDER BY beli.NoBukti";
}
else {
	$sql = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang ORDER BY beli.NoBukti";
}

if(isset($_GET['starting'])) {
	$starting = $_GET['starting'];
} else {
	$starting = 0;
}

$recpage = 10;
$obj = new pagination_class($sql,$starting,$recpage);
$result = $obj->result;
?>

<table id="tblpembelian">
	<tr>
    	<th>No</th>
        <th>No. Bukti</th>
        <th>Tanggal Beli</th>
        <th>ID Vendor</th>
        <th>Nama Vendor</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Qty</th>
        <th>Jumlah Uang</th>
        <th>Aksi</th>
    </tr>
    	<?php
			$no = 0;
			//menampilkan data pembelian
			if(mysql_num_rows($result)!=0) {
				while($row = mysql_fetch_array($result)) {
		?>
    <tr>
    	<td><?php echo ++$no; ?></td>
        <td><?php echo $row['NoBukti']; ?></td>
    	<td><?php echo date('d-m-Y',strtotime($row['TglBeli'])); ?></td>
        <td><?php echo $row['IdVendor']; ?></td>
        <td><?php echo $row['Nama']; ?></td>
        <td><?php echo $row['KdBarang']; ?></td>
        <td><?php echo $row['NmBarang']; ?></td>
        <td>Rp. <?php echo number_format($row['Harga']); ?></td>
        <td><?php echo $row['Stok']; ?></td>
        <td><?php echo $row['Qty']; ?></td>
        <td align="right">Rp. <?php echo number_format($row['jmluang']); ?></td>
        <td><a href="formpembelian.php?action=update&no=<?php echo $row['NoBukti']; ?>" class="edit">Edit</a> | <a href="proses_data.php?action=delete&no=<?php echo $row['NoBukti']; ?>" class="delete">Delete</a></td>
    </tr>
    	<?php } ?>
    <tr id="nav"><td colspan="12"><?php echo $obj->anchors; ?></td></tr>
    <tr id="total"><td colspan="12"><?php echo $obj->total; ?></td></tr>

    	<?php } else { ?>
    <tr>
    	<td align="center" colspan="12">Data Tidak Ditemukan!</td>
    </tr>
    	<?php } ?>
</table>