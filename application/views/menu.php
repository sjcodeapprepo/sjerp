<script type="text/javascript" src="<?=base_url()?>publicfolder/jslib/fg-menu/fg-menu/fg.menu.js"></script>
<link type="text/css" href="<?=base_url()?>publicfolder/jslib/fg-menu/fg-menu/fg.menu.css" media="screen" rel="stylesheet" />

	<style type="text/css">
	input, select, textarea { border:1px solid #D4E0EE; background-color: white;}
	/*
	input[type="submit"], button, input[type="button"], input[type="reset"] {
		padding: 4px 15px 4px !important;
		font-size: 14px !important;
		background-color: #414476;
		font-weight: bold;
		text-shadow: 1px 1px #57D6C7;
		color: #f4f4f4;
		border-radius: 5px;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border: 1px solid #57D6C7;
		cursor: pointer;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
		-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
		-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;
	}
	*/
	input[readonly] {
		background-color: #F6F6F6;
		color: #A2A2A2;
	}
	
	.ui-datepicker{
		font-size:small;
	}

	.menu, li a { font-size:72.5%; margin:0; padding:0; }
	#menuLog { font-size:1.4em; margin:20px; }
	.hidden { position:absolute; top:0; left:-9999px; width:1px; height:1px; overflow:hidden; }

	.fg-button { clear:left; margin:32px 4px 40px 10px; padding: .4em 1em; text-decoration:none !important; cursor:pointer; position: absolute; text-align: center; zoom: 1; }
	.fg-button .ui-icon { position: absolute; top: 50%; margin-top: -8px; left: 50%; margin-left: -8px; }
	a.fg-button { float:left;  }
	button.fg-button { width:auto; overflow:visible; } /* removes extra button width in IE */

	/* .fg-button-icon-left { padding-left: 2.1em; }
	.fg-button-icon-right { padding-right: 2.1em; }
	.fg-button-icon-left .ui-icon { right: auto; left: .2em; margin-left: 0; }
	.fg-button-icon-right .ui-icon { left: auto; right: .2em; margin-left: 0; }
	.fg-button-icon-solo { display:block; width:8px; text-indent: -9999px; }	 solo icon buttons must have block properties for the text-indent to work */

	/* .fg-button.ui-state-loading .ui-icon { background: url(spinner_bar.gif) no-repeat 0 0; } */

	div.menudash {
		width: 22px;
		height: 3px;
		background-color: #414476;
		margin: 2px 0;
	}
	#headermenu{
		position:relative;
		clear:left;
		margin:0px 0px 0px 5px;
	}
	#header{
		position:absolute;
		top:2px;
		left:10px;
		height:px;
		width:98%;
		border: 1px solid #D4E0EE;
		border-collapse: collapse;
		font-family: "Trebuchet MS", Arial, sans-serif;
		font-weight:bold;
		font-size:24px;
		background-color: white;
		color: #414476;
		text-align:right;
		overflow:hidden;
	}
	#spacebottom{
		position:float;
		height:70px;
	}
	</style>
<script type="text/javascript">
function goToUrl(urladdress){	
	if(urladdress !='' || urladdress!='#'){
		window.location=urladdress;
	}
}
$(document).ready(function(){
	$('.fg-button').hover(
		function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
		function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
	);
	$('#programho').menu({
		content: $('#homenu').html(),
		flyOut: false,
		backLink: false,
		maxHeight: 380
	});

 });
 </script>
<div id="headermenu">
<div id="header">
	<img src="<?=base_url()?>publicfolder/image/sjlog.png" width="200" height="50" />&nbsp;&nbsp;
</div>
<div class="menu">	
<a tabindex="0" href="#homenu" class="fg-button" id="programho">
	<div class="menudash"></div>
	<div class="menudash"></div>
	<div class="menudash"></div>
</a>
<div id="homenu" class="hidden">
<ul>	
<?php
$parentgrouparr	= array_keys($menuarr);
for ($i = 0; $i < count($parentgrouparr); $i++) {
	$parentgroup = $parentgrouparr[$i];	
	if($parentgroup!='Utility') {
?>
	<li>
		<a href="#"><?=$parentgroup?></a>
		<ul>
<?php		
		$grouparr	= array_keys($menuarr[$parentgroup]);
		for ($j = 0; $j < count($grouparr); $j++) {
			$group	= $grouparr[$j];
?>
			<li>
				<a href="#"><?=$group?></a>
				<ul>	
<?php
			for ($k = 0; $k < count($menuarr[$parentgroup][$group]['menuid']); $k++) {
				$url		= $menuarr[$parentgroup][$group]['url'][$k];
				$menuname	= $menuarr[$parentgroup][$group]['menuname'][$k];
?>
				<li><a href="<?=site_url().'/'.$url?>"><?=$menuname?></a></li>
<?php		} ?>
				</ul>
			</li>			
<?php
		}
?>
		</ul>
	</li>
<?php		
	}
} 
?>

<?php if(isset($menuarr['Utility'])) { ?>
	<li>
		<a href="#">Utility</a>
		<ul>
			<?php
			for ($l = 0; $l < count($menuarr['Utility']['Utility']['menuid']); $l++) {
				$url		= $menuarr['Utility']['Utility']['url'][$l];
				$menuname	= $menuarr['Utility']['Utility']['menuname'][$l];
			?>
			<li><a href="<?=site_url().'/'.$url?>"><?=$menuname?></a></li>
			<?php } ?>
		</ul>
	</li>
<?php } ?>
	
	<li><a href="<?=site_url()?>/auth/login/logout">Logout</a></li>	
</ul>
</div>
</div>
</div>
<div id="spacebottom"></div>