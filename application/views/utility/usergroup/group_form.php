<html>
<head>
<link type="text/css" href="<?php echo base_url(); ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
<style>
.lebariconkecil{
	width:18px;
}
</style>
<body>
<?php 
	$this->load->view('js/jqueryui');
	menulist();
	?>
	<br />
	<br />
	<br />
	<br />

<table class="gridtable" align="center" style="width:400px;">
	<thead>
		<tr>
			<th align='left' width='40'>Kodes</th>
			<th align='left' width='120'>Group Pengguna</th>
			<th align='center' width='60'></th>
		</tr>
	</thead>
	<tbody>
<?php for($a=0 ; $a<count($usergroupmst) ; $a++){ ?>
      <tr>
        <td><?=$usergroupmst[$a]['UserGroupID'];?></td>
        <td><?=$usergroupmst[$a]['UserGroupName'];?></td>
        <td align="center">
			<div title="EDIT" class="ui-state-default ui-corner-all lebariconkecil"><a href='<?php echo base_url();?>index.php/utility/group/edit/<?=$usergroupmst[$a]['UserGroupID'];?>'><span class="ui-icon ui-icon-pencil"/></a></div>
		</td>
	  </tr>
<?php } ?>
	</tbody>
</table>
</body>
</html>