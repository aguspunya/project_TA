<?php
$id = $_POST['idVend'];

include_once "config.php";

$str = "SELECT * FROM vendor WHERE IdVendor = '$id'";
$res = mysql_query($str) or die ("Query Gagal Dijalankan!");
$data = mysql_fetch_assoc($res);
?>

<table>
    <tr>
        <td width="110">Nama Vendor</td>
        <td><input type="text" name="namavendor" id="namavendor" size="30" readonly value="<?php echo $data['Nama']; ?>"/></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td><input type="text" name="alamat" id="alamat" size="40" readonly value="<?php echo $data['Alamat']; ?>" /></td>
    </tr>
    <tr>
        <td>Kota</td>
        <td><input type="text" name="kota" id="kota" size="25" readonly value="<?php echo $data['Kota']; ?>" /></td>
    </tr>
    <tr>
        <td>Telpon</td>
    	<td><input type="text" name="telpon" id="telpon" size="20" readonly value="<?php echo $data['Telp']; ?>" /></td>
	</tr>
    <tr>
        <td>Email</td>
    	<td><input type="text" name="email" id="email" size="35" readonly value="<?php echo $data['Email']; ?>" /></td>
	</tr>
</table>