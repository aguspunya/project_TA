$(document).ready(function(){
 
  //menangkap error dan men-set parameter global (timeout, dll)
  $.ajaxSetup({
    timeout: 10000,
    cache: false,
    error:function(x,e){
        if(x.status==0){
          alert('Anda sedang offline!\nSilahkan cek koneksi anda!');
        }else if(x.status==404){
          alert('Permintaan URL tidak ditemukan!');
        }else if(x.status==500){
          alert('Internal Server Error!');
        }else if(e=='parsererror'){
          alert('Error.\nParsing JSON Request failed!');
        }else if(e=='timeout'){
          alert('Request Time out!');
        }else {
          alert('Error tidak diketahui: \n'+x.responseText);
        }
    }
  });
 
  // menampilkan image untuk menandakan proses Ajax sedang berlangsung atau telah selesai
  $('#divLoading').ajaxStart(function(){
    $(this).fadeIn();
    $(this).html("<img src='images/ajax-loader.gif' /> ");
  }).ajaxStop(function(){
    $(this).fadeOut();
  });
 
  $("#btnhide").hide();
 
  // ketika tombol tambah di-klik, maka formpembelian akan ditampilkan pada bagian #divFormContent
  $("#btntambah").click(function(){
    page="formpembelian.php";
    $("#divFormContent").load(page);
    $("#divFormContent").show();
    $("#btnhide").show();
    return false;
  });
  
  //ketika tombol tambah vendor di-klik, maka formvendor akan ditampilkan pada bagian #divFormContent
  $("#btnvend").click(function(){
    page="formvendor.php";
    $("#divFormContent").load(page);
    $("#divFormContent").show();
    $("#btnhide").show();
    return false;
  });
  
  //ketika tombol tambah barang di-klik, maka formbarang akan ditampilkan pada bagian #divFormContent
  $("#btnbrg").click(function(){
    page="formbarang.php";
    $("#divFormContent").load(page);
    $("#divFormContent").show();
    $("#btnhide").show();
    return false;
  });
 
  $("#btnhide").click(function(){
    $("#divFormContent").toggle();
    return false;
  });
 
  //menangani jika user melakukan pilihan pada combo #pilihcari
  $("select#pilihcari").change(function(){
    if ($(this).val() == "nobukti"){
      $("td#kolompilih").show();
      $("input#fieldcari").show();
      $("input#fieldcari").focus();
    }
    else if ($(this).val() == "idvendor"){
      $("td#kolompilih").show();
      $("input#fieldcari").show();
      $("input#fieldcari").focus();
    }
	 else if ($(this).val() == "nmvendor"){
      $("td#kolompilih").show();
      $("input#fieldcari").show();
      $("input#fieldcari").focus();
    }
	 else if ($(this).val() == "kdbarang"){
      $("td#kolompilih").show();
      $("input#fieldcari").show();
      $("input#fieldcari").focus();
    }
	 else if ($(this).val() == "nmbarang"){
      $("td#kolompilih").show();
      $("input#fieldcari").show();
      $("input#fieldcari").focus();
    }
    else{
      $("td#kolompilih").hide();
    }
  });
 
  //menampilkan list data pelanggan
  loadData();
 
  // fungsi untuk me-load tampilan list data pembelian, data yang ditampilkan disesuaikan
  // juga dengan input data pada bagian search
  function loadData(){
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
      success:function(data)
      {
        $('#divPageData').html(data);
      }
    });
  }
 
  // melakukan pemrosesan data untuk bagian search (pencarian data)
  $("form#formSearch").submit(function(){
    var cari = $("input#fieldcari").val();
    var combo = $("select#pilihcari").val();
    if (cari.replace(/\s/g,"") != ""){ // mengecek field text kosong atau tidak)
        loadData();
    }
    else if ((cari.replace(/\s/g,"") == "") && (combo != "semua") ){
      alert("Maaf, field harus diisi!");
      $("input#fieldcari").focus();
    }
    else{
      loadData();
    }
    return false;
  });
 
});

