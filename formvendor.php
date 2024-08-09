<?php

include_once "config.php";

$action = "addvend";
$judul = "Data Vendor";
$nama = "";
$alamat = "";
$kota = "";
$telp = "";
$email = "";
$status = "Save";
?>

<script type="text/javascript">
	$(function() {
		$("input#namavendor").focus();
		
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
		
		$("form#formVendor").submit(function() {
			if(confirm("Apakah benar akan menyimpan data vendor ini ?")) {
				var vNama = $("input#namavendor").val();
				var vAlamat = $("textarea#alamat").val();
				var vKota = $("input#kota").val();
				var vTelp = $("input#telp").val();
				var vEmail = $("input#email").val();
				
				//cek validasi semua form dahulu, field data harus diisi
				if((vNama.replace(/\s/g,"") == "") || (vAlamat.replace(/\s/g,"") == "") || (vKota.replace(/\s/g,"") == "") || (vTelp.replace(/\s/g,"") == "") || (vEmail.replace(/\s/g,"") == "")) {
					alert("Mohon melengkapi semua field data!");
					$("input#namavendor").focus();
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
								$("#divFormContent").load("formvendor.php");
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

<form method="post" name="formVendor" id="formVendor">
	<table>
    	<tr>
        	<th colspan="2"><b><?php echo $judul; ?></b></th>
        </tr>
        <tr>
        	<td>Nama Vendor</td>
            <td><input type="text" id="namavendor" name="namavendor" size="30" value="<?php echo $nama; ?>" /></td>
        </tr>
        <tr>
        	<td>Alamat</td>
            <td><textarea name="alamat" id="alamat" cols="30" rows="4"><?php echo $alamat; ?></textarea></td>
        </tr>
        <tr>
        	<td>Kota</td>
            <td><input type="text" id="kota" name="kota" size="25" value="<?php echo $kota; ?>" /></td>
        </tr>
        <tr>
        	<td>Telp</td>
            <td><input type="text" id="telp" name="telp" size="20" value="<?php echo $telp; ?>" /></td>
        </tr>
        <tr>
        	<td>Email</td>
            <td><input type="text" id="email" name="email" size="30" value="<?php echo $email; ?>" /></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" value="<?php echo $status; ?>" />
            	<input type="reset" value="Cancel" name="cancel" id="cancel" /></td>
        </tr>
    </table>
    <input type="hidden" name="action" value="<?php echo $action; ?>" />
</form>