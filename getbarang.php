<?php
$id = $_POST['kdBrg'];

include_once "config.php";

$str = "SELECT * FROM barang WHERE KdBarang = '$id'";
$res = mysql_query($str) or die ("Query Gagal Dijalankan!");
$data = mysql_fetch_assoc($res);
?>

<table>
	<tr>
    	<td width="110">Nama Barang</td>
        <td><input type="text" name="nmbarang" id="nmbarang" size="30" readonly value="<?php echo $data['NmBarang']; ?>" /></td>
    </tr>
    <tr>
        <td>Harga</td>
        <td><input type="text" name="harga" id="harga" size="15" readonly value="<?php echo $data['Harga']; ?>" /></td>
    </tr>
    <tr>
        <td>Stok</td>
    	<td><input type="text" name="stok" id="stok" size="10" readonly value="<?php echo $data['Stok']; ?>" /></td>
	</tr>
    <tr>
        <td>Stok Minimum</td>
    	<td><input type="text" name="stokmin" id="stokmin" size="10" readonly value="<?php echo $data['StokMinimum']; ?>" /></td>
	</tr>
</table>