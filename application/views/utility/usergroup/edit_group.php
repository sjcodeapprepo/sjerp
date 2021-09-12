<html>
<head>
	<title>Group Pengguna</title>
	<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<style type="text/css">
table thead tr th, table tbody tr td {
  	margin: 0px;
	padding:0px;
}
#b1 {
	position:relative;
	left:120px;
	width:860px;
}
#b2a{
	position:absolute;
	top:25px;
	height:250px;
	width:740px;
	overflow:auto;
}
#t2a{
	position:absolute;
}
#t2b{

}
#t3{
	position:absolute;
	top:280px;
	left:350px;
}
</style>
</head>
<body>
<?php 
	$this->load->view('js/jqueryui');
	menulist();
	?>
	<br />
	<br />
<form action='<?php echo base_url();?>index.php/utility/group/edit' method='post'>
<?php $count = count($menumst); ?>
<input type=hidden name=total value='<?=$count;?>'>
<table align=center style="width:350" class="gridtable">
	<thead>
	<tr><th colspan='2' height='30'>EDIT GROUP PENGGUNA</th></tr>
	</thead
      <tr>
        <td align=right>Kode : </td>
        <td align=left><input size=15 name='UserGroupID' value='<?=$view_usergroupmst_edit[0]['UserGroupID'];?>' readonly=1></td>
	  </tr>
      <tr>
        <td align=right>Group Pengguna : </td>
        <td align=left><input size=15 name='UserGroupName' value='<?=$view_usergroupmst_edit[0]['UserGroupName'];?>'></td>
	  </tr>
</table>
<br />

<table align=center><tr><td>

<div id="b1">
<table class="gridtable" id="t2a">
	<thead>
	<tr>
		<th width=130 align=left>Group Menu</th>
		<th width=300 align=left>Menu</th>
		<th width=120 align=center>Baca</th>
		<th width=120 align=center>Modifikasi</th>
	</tr>
	</thead>
</table>
<div id="b2a">
	<table class="gridtable" id="t2b">
			<? for($a=0 ; $a<count($menumst) ; $a++){ ?>
			<tr>
			<td width=130><input type=hidden name='MenuID[]' value='<?=$menumst[$a]['MenuID'];?>' readonly=1>
			<?=$menumst[$a]['GroupName'];?>
			</td>
			<td width=300><?=$menumst[$a]['MenuName'];?></td>

			<td width=120 align=center>
			<? if($view_usergroupdtlmst_edit[$a]['ReadFlg'] == 1){ ?>
				<input type=checkbox name='ReadFlg[]' value='<?=$menumst[$a]['MenuID'];?>' checked>
			<? }else{ ?>
				<input type=checkbox name='ReadFlg[]' value='<?=$menumst[$a]['MenuID'];?>'>
			<? } ?>
			</td>

			<td width=120 align=center>
			<? if($view_usergroupdtlmst_edit[$a]['ModifyFlg'] == 1){ ?>
				<input type=checkbox name='ModifyFlg[]' value='<?=$menumst[$a]['MenuID'];?>' checked>
			<? }else{ ?>
				<input type=checkbox name='ModifyFlg[]' value='<?=$menumst[$a]['MenuID'];?>'>
			<? } ?>
			</td>

	   </tr>
			<? } ?>
</table>
</div>
	<table align="center" id="t3">
	   	<tr align=center height=50>
        <td colspan='2'>
        <input type=hidden name=kirim value=1>
        <?php if ($modifyflag){?>
		<input type=submit value=SIMPAN name=submit class='button'>
		<input type=reset name=reset value=BATAL class='button'>
		<?php }
		else {?>
		<input type=reset name=reset value=BATAL onclick="window.location='<?=base_url().'index.php/utility/group';?>'">
 <?php } ?>
		</td>
	  </tr>
 </table>
</div>

		</td></tr></table>
</form>
</body>
</html>