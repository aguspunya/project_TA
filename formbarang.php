<?php

include_once "config.php";

$action = "addbrg";
$judul = "Data Barang";
$nama = "";
$harga = "";
$stok = "";
$stokmin = "";
$status = "Save";
?>

<script type="text/javascript">
	$(function() {
		$("input#namabarang").focus();
		
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
		
		$("form#formBarang").submit(function() {
			if(confirm("Apakah benar akan menyimpan data barang ini ?")) {
				var vNama = $("input#namabarang").val();
				var vHarga = $("input#harga").val();
				var vStok = $("input#stok").val();
				var vStokmin = $("input#stokmin").val();
				var myRegExp = /^[0-9]+$/;
				
				//cek validasi semua form dahulu, field data harus diisi
				if((vNama.replace(/\s/g,"") == "") || (vHarga.replace(/\s/g,"") == "") || (vStok.replace(/\s/g,"") == "") || (vStokmin.replace(/\s/g,"") == "")) {
					alert("Mohon melengkapi semua field data!");
					$("input#namabarang").focus();
					return false;
				}
				//cek validasi Stok
				else if (!myRegExp.test(vStok)){
					alert("Stok harus berisi angka!");
					$("input#stok").focus();
					return false;
				}
				//cek validasi Stok Minimum
				else if (!myRegExp.test(vStokmin)){
					alert("Stok Minimum harus berisi angka!");
					$("input#stokmin").focus();
					return false;
				} else {
					$.ajax({
						url: "proses_data.php",
						type: $(this).attr("method"),
						data: $(this).serialize(),
						dataType: 'json',
						success: function(response){
							if(response.status == 1) {
								alert("Data berhasil disimpan!");
								loadData();
								$("#divFormContent").load("formbarang.php");
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

<form method="post" name="formBarang" id="formBarang">
	<table>
    	<tr>
        	<th colspan="2"><b><?php echo $judul; ?></b></th>
        </tr>
        <tr>
        	<td>Nama Barang</td>
            <td><input type="text" id="namabarang" name="namabarang" size="30" value="<?php echo $nama; ?>" /></td>
        </tr>
        <tr>
        	<td>Harga</td>
            <td><input type="text" id="harga" name="harga" size="20" value="<?php echo $harga; ?>" /></td>
        </tr>
        <tr>
        	<td>Stok</td>
            <td><input type="text" id="stok" name="stok" size="10" value="<?php echo $stok; ?>" /></td>
        </tr>
        <tr>
        	<td>Stok Minimum</td>
            <td><input type="text" id="stokmin" name="stokmin" size="10" value="<?php echo $stokmin; ?>" /></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" value="<?php echo $status; ?>" />
            	<input type="reset" value="Cancel" name="cancel" id="cancel" /></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="<?php echo $action; ?>" />
</form>