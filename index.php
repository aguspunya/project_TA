<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UTS PHP AJAX</title>
<link rel="stylesheet" type="text/css" href="css/style-page.css" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/pembelian.js"></script>
</head>

<body>
<div id="divFormContent"></div>
<br />

<div>
<input type="button" value="Add Purchase" id="btntambah" />
<input type="button" value="Add Vendor" id="btnvend" />
<input type="button" value="Add Barang" id="btnbrg" />
<input type="button" value="Show/hide" id="btnhide" /></div>
<br />
<br />

<div id="divSearch">
	<form id="formSearch">
    	<table>
        	<tr>
            	<td>Searching Data : 
              	<select id="pilihcari">
                		<option value="nobukti">No. Bukti</option>
                        <option value="idvendor">ID Vendor</option>
                        <option value="nmvendor">Nama Vendor</option>
                        <option value="kdbarang">Kode Barang</option>
                        <option value="nmbarang">Nama Barang</option>
                        <option value="semua">Semua</option>
                </select></td>
                <td id="kolompilih"><input type="text" name="fieldcari" id="fieldcari" /></td>
                <td><input type="submit" value="Search" /></td>
            </tr>
        </table>
    </form>
</div>
<br />

<div id="divLoading"></div>
<div id="divPageData"></div>
</body>
</html>