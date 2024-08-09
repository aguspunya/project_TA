<?php

include_once "config.php";

$action = "add";
$judul = "Form Pembelian Barang";
$tgl = "";
$qty = "";
$status = "Save";

if(isset($_GET['action']) and $_GET['action'] == "update" and !empty ($_GET['no']))	{
	$str = "SELECT beli.NoBukti, beli.TglBeli, beli.IdVendor, vendor.Nama, beli.KdBarang, barang.NmBarang, barang.Harga, barang.Stok, beli.Qty, barang.Harga * beli.Qty as jmluang FROM beli inner join vendor on beli.IdVendor=vendor.IdVendor inner join barang on beli.KdBarang=barang.KdBarang WHERE NoBukti = '$_GET[no]'";
	$res = mysql_query($str) or die ("Query Gagal Dijalankan");
	$data = mysql_fetch_assoc($res);
	
	$nobuk = $data['NoBukti'];
	$tgl = $data['TglBeli'];
	$qty = $data['Qty'];
	$action = "update";
	$readonly = "readonly=readonly";
	$status = "Update";
	$judul = "Update Data Pembelian Barang";
}
?>

<script type="text/javascript">
	$(function() {
		$("input#tglbeli").focus();
		
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
		
		$("form#formPembelian").submit(function() {
			if(confirm("Apakah benar akan menyimpan data pembelian ini ?")) {
				var vTgl = $("input#tglbeli").val();
				var vQty = $("input#qty").val();
				var vIdvend = $("select#cbVend").val();
				var vKdbrg = $("select#cbBarang").val();
				var vStok = $("input#stok").val();
				var vStokmin = $("input#stokmin").val();
				var myRegExp = /^[0-9]+$/;
				
				//cek validasi semua form dahulu, field data harus diisi
				if((vTgl.replace(/\s/g,"") == "") || (vQty.replace(/\s/g,"") == "") || (vIdvend.replace(/\s/g,"") == "") || (vKdbrg.replace(/\s/g,"") == "")) {
					alert("Mohon melengkapi semua field data!");
					$("input#tglbeli").focus();
					return false;
				}
				//cek validasi Qty
				else if(!myRegExp.test(vQty)) {
					alert("Qty harus berisi angka!");
					$("input#qty").focus();
					return false;
				}
				//cek validasi jika Qty tidak boleh melebihi Stok
				else if(parseInt(vStok) < parseInt(vQty)) {
					alert("Qty tidak boleh melebihi Stok!");
					$("input#qty").focus();
					return false;
				}
				// cek validasi stok kurang atau sama dengan stok minimum
				else if(parseInt(vStok) <= parseInt(vStokmin)) {
					alert("Stok sudah mencapai batas minimum!");
					$("input#qty").focus();
					return false;
				}
				else {
					$.ajax({
						url: "proses_data.php",
						type: $(this).attr("method"),
						data: $(this).serialize(),
						dataType: 'json',
						success: function(response){
							if(response.status == 1) {
								alert("Data berhasil disimpan!");
								loadData();
								$("#divFormContent").load("formpembelian.php");
								$("#divFormContent").hide();
								$("#btnhide").hide();
							} else {
								alert("Data gagal disimpan!");
							}
						}
					});
					return false;
				}
			}
			return false;
		});
	});
</script>

<script type="text/javascript">
	$(function() {
		$("#cbVend").change(function() {
			var idVend = $(this).val();
			
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "getvendor.php",
				data: "idVend="+idVend,
				success: function(msg) {
					if(msg == ''){
					} else {
						$("#vendor").html(msg);
					}
				}
			});
		});
	});
	
	$(function() {
		$("#cbBarang").change(function() {
			var kdBrg = $(this).val();
			
			$.ajax({
				type: "POST",
				dataType: "html",
				url: "getbarang.php",
				data: "kdBrg="+kdBrg,
				success: function(msg) {
					if(msg == ''){
					} else {
						$("#barang").html(msg);
					}
					$("#qty").focus();
				}
			});
		});
	});
</script>

<form method="post" name="formPembelian" id="formPembelian">
	<table>
    	<tr>
        	<th colspan="2"><b><?php echo $judul; ?></b></th>
        </tr>
        <!-- jika update maka No Bukti ditampilkan -->
        <?php if($action == "update") { ?>
        <tr>
        	<td width="110">No. Bukti</td>
            <td><input type="text" id="nobukti" name="nobukti" size="10" <?php echo $readonly; ?> value="<?php echo $nobuk; ?>" /></td>
        </tr>
        <?php } ?>
        <tr>
        	<td>Tanggal Beli</td>
            <td><input type="text" id="tglbeli" name="tglbeli" size="20" value="<?php echo $tgl; ?>" /></td>
        </tr>
        <tr>
        	<td>ID Vendor</td>
            <td><select name="cbVend" id="cbVend">
            		<option value="">-- Pilih ID Vendor --</option>
                    	<?php
							$query = "SELECT * FROM vendor";
							$rs = mysql_query($query);
							while($result_data = mysql_fetch_array($rs)) {
								list($IdVendor, $Nama, $Alamat, $Kota, $Telp, $Email) = $result_data;
						?>
                    <option value="<?php echo $IdVendor; ?>"><?php echo $IdVendor; ?></option>
                    	<?php } ?>
            </select></td>
        </tr>
        <tr>
        	<td colspan="2">
            <div id="vendor"></div>
            </td>
        </tr>
        <tr>
        	<td>Kode Barang</td>
            <td><select name="cbBarang" id="cbBarang">
            		<option value="">-- Pilih Kode Barang --</option>
                    	<?php
							$query = "SELECT * FROM barang";
							$rs = mysql_query($query);
							while($result_data = mysql_fetch_array($rs)) {
								list($KdBarang, $NmBarang, $Harga, $Stok, $StokMinimum) = $result_data;
						?>
                    <option value="<?php echo $KdBarang; ?>"><?php echo $KdBarang; ?></option>
                    	<?php } ?>
            </select></td>
        </tr>
        <tr>
        	<td colspan="2">
            <div id="barang"></div>
            </td>
        </tr>
        <tr>
        	<td>Qty</td>
            <td><input type="text" name="qty" id="qty" size="10" /></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" value="<?php echo $status; ?>" />
            	<input type="reset" value="Cancel" name="reset" id="reset" /></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="<?php echo $action; ?>" />
    <input type="hidden" name="stokmin" id="stokmin" value="<?php echo $stokmin; ?>" />
    <input type="hidden" name="stok" id="stok" value="<?php echo $stok; ?>" />
</form>