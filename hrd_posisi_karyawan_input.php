<?php

/**
 * @author gatot
 * @copyright 2009
 */

// user_add.php
getLevelTwoTitle($ACLID,$_GET['sub']);
getLevelThreeTitle($ACL2ID,$_GET['action']);
echo "<h3>$LV2TITLE | $LV3TITLE</h3>";
$serverName="WWID";
$info=array("Database"=>"DC_ERP","UID"=>"sa","PWD"=>"Aa123456","CharacterSet"=>"UTF-8");
$conn = sqlsrv_connect($serverName, $info);
if(!isset($_POST['btx'])){
//awal paging

// jumlah data yang akan ditampilkan per halaman

$dataPerPage = 100;

// apabila $_GET['page'] sudah didefinisikan, gunakan nomor halaman tersebut, 
// sedangkan apabila belum, nomor halamannya 1.

if(isset($_GET['page']))
{
    $noPage = $_GET['page'];
	$dataPerPage1=$dataPerPage * $_GET['page'];
}else{
 $noPage = 1;
$dataPerPage1=$dataPerPage;
// perhitungan offset
}
$offset = ($noPage - 1) * $dataPerPage;

$quv = sqlsrv_query($conn,"SELECT * FROM t_PALM_personnelfilemst_posisi ORDER BY id ASC ") or die(sqlsrv_error());
$nuv = sqlsrv_num_rows($quv);
//sqlsrv_close($conn);
if($_GET['x']=="0"){

$data=sqlsrv_fetch_array(sqlsrv_query($conn,"select * from t_PALM_personnelfilemst_posisi where fCode='$_GET[eid]'"));
}elseif($_GET['x']=="1"){

$quv = sqlsrv_query($conn,"delete from t_PALM_personnelfilemst_posisi where kode='$_GET[eid]'") or die(sqlsrv_error());

echo "<script type=\"text/javascript\">";
echo "alert('Data berhasil dihapus!!!')";
echo "</script>";				

//include ('./includes/del_satuan.php');
$quv = sqlsrv_query($conn,"SELECT * FROM t_PALM_personnelfilemst_posisi ORDER BY id ASC") or die(sqlsrv_error());
sqlsrv_close();
$nuv = sqlsrv_num_rows($quv);
//$_GET['x']=="3";
//				echo "<meta http-equiv=\"refresh\" content=\"1;URL=\"./?c=$_GET[c]&amp;sub=$_GET[sub]&action=satuan\"\">";
echo "Anda dalam mode disable, untuk input <b>Jenis</b> baru anda harus klik <a href=\"./?c=$_GET[c]&amp;sub=$_GET[sub]&action=data\"\"><b>Disini</b></a>";
}
?>
<script type="text/javascript">

function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;

</script> 
<style type="text/css"/>
table, td{
	font:100% Arial, Helvetica, sans-serif; 
}
table{width:100%;border-collapse:collapse;margin:1em 0;}
th, td{text-align:left;padding:.5em;border:1px solid #fff;}
th{background:#328aa4 url(../images/tr_back.gif) repeat-x;color:#fff;}
td{background:#e5f1f4;}

/* tablecloth styles */

tr.even td{background:#e5f1f4;}
tr.odd td{background:#f8fbfc;}

th.over, tr.even th.over, tr.odd th.over{background:#4a98af;}
th.down, tr.even th.down, tr.odd th.down{background:#bce774;}
th.selected, tr.even th.selected, tr.odd th.selected{}

td.over, tr.even td.over, tr.odd td.over{background:#ecfbd4;}
td.down, tr.even td.down, tr.odd td.down{background:#bce774;color:#fff;}
td.selected, tr.even td.selected, tr.odd td.selected{background:#bce774;color:#555;}

/* use this if you want to apply different styleing to empty table cells*/
td.empty, tr.odd td.empty, tr.even td.empty{background:#fff;}
</style>
	
<div id="boxy" >
<form method="post" action="#">
<table width="100%" border="0">
<tr>
<td>NIK</td>
<td><input type="text" name="nik" id="nik" size="20" value="<?php echo $data[fCode];?>"/></td>
</tr>
</table>
<hr />
<table width="100%" border="0">
<tr>
<td>Nama</td>
<td><input type="text" name="nama" id="nama" size="70" value="<?php echo $data[fName];?>"/></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>Posisi</td>
<td><select name="posisi" id="posisi"/>
<option value="" selected="selected">Pilih</option>
<?php
$posisi=sqlsrv_query($conn,"select * from t_PALM_posisimst order by id");
while($dtposisi=sqlsrv_fetch_array($posisi)){
if($data['fPosisi']==$dtposisi['kode']){
echo "<option value='$dtposisi[kode]' selected='selected'>$dtposisi[nama]</option>";
}else{
echo "<option value='$dtposisi[kode]'>$dtposisi[nama]</option>";
}
}
?>
</select>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>

</table>
<hr />
<input type="reset" value="Reset"/>&nbsp;<input type="submit" name="btx" value="Add"/>
</fieldset>
</form>
<?php echo "$nuv"?>
<table cellspacing="0" cellpadding="0">			
	<tr>				
		<th>No</th>
		<th>Nik</th>
		<th>Nama</th>
		<th>Posisi</th>
		<th>Tool</th>
	</tr>
<?php
//   for($iuv=0;$iuv<$nuv;$iuv++){
$no=0;
  while($auv = sqlsrv_fetch_array($quv)){
$no++; 
 // getMyOfficeCode($auv['office_id']);
   	 // getMyOfficeBranch($auv['office_id']);
      //
   	  $view = "<tr>";
	  $view.= "<td width=\"40\">";
	  $view.= $no;
	  $view.= "</td>";
	  $view.= "<td>";
	  $view.= $auv['fCode'];
	  $view.= "</td>";	
	  $view.= "<td>";
	  $view.= ucwords($auv['fName']);
	  $view.= "</td>"; 
	  $view.= "<td>";
	  $posisi=sqlsrv_fetch_array(sqlsrv_query($conn,"select nama from t_PALM_posisimst where kode='$auv[fPosisi]'"));
	  $view.= ucwords($posisi['nama']);
	  $view.= "</td>"; 	  
	  $view.= "<td width=\"40\">";
	  $view.= "<a href=\"./?c=$_GET[c]&amp;sub=$_GET[sub]&action=input&amp;eid=$auv[fCode]&x=0\">";
	  $view.= "edit";
	  $view.= "</a>&nbsp;&nbsp;";
	  $view.= "<a href=\"./?c=$_GET[c]&amp;sub=$_GET[sub]&action=input&amp;eid=$auv[fCode]&x=1\">";
	  $view.= "delete";
	  $view.= "</a>";
	  $view.= "</td>";
   	  $view.= "</tr>";
   	  //
   	  echo $view;
   }
 
?>	

</table>

<?php
}else{
if(empty($_POST['nik'])||empty($_POST['nama'])){
		echo "<div id=\"errbox\">";		
		echo "You did not fill all required fields!";
		echo "<p><a href=\"javascript: history.back()\">Back to form</a></p>";		
		echo "</div>";
	} else {
	if(($_GET['x']!="0"))
	{
				
				//// good to go
				
				$q = sqlsrv_query($conn,"INSERT INTO t_PALM_personnelfilemst_posisi (
				fCode,
				fName,
				fPosisi
				) VALUES (
				'$_POST[nik]','$_POST[nama]','$_POST[posisi]')");
				sqlsrv_close($conn);
				echo "<div id=\"okbox\">";		
				echo "A new record has been added";		
				echo "</div>";
				
}else{

				$q = sqlsrv_query($conn,"update t_PALM_personnelfilemst_posisi set 
				fCode='$_POST[nik]',
				fName='$_POST[nama]',
				fPosisi='$_POST[posisi]' where fCode='$_GET[eid]'")
				;
				sqlsrv_close($conn);
//	echo $q;			
				echo "<div id=\"okbox\">";		
				echo "A new record has been updated...";		
				echo "</div>";
//var_dump($q);
}	

	

}
}
	?>

<h2>      &nbsp;</h2>
</div>


