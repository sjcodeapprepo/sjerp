<html>

<head>
    <title>Aset Perlengkapan dan Peralatan - input</title>
    <link type="text/css" href="<?= base_url() ?>publicfolder/cssdir/csstable/tablegrid.css" media="screen" rel="stylesheet" />
    <?php
		$this->load->view('js/jqueryui');
		$this->load->view('js/TextValidation');
        $this->load->view('js/SelectValidation');
    ?>
    <style>
        .msg {
            color: red;
            text-align: center;
            font-weight: bold;
        }
        .subdata {
            font-weight: bold;
            font-style: italic;
            background-color: #F4F4F4;
        }

        .fixwidthkecil {
            width: 80px;
        }

        .fixwidthsedang {
            width: 180px;
        }
        .fixwidthlebar{
            width:500px;
    	}

        .ratakanan {
            text-align: right;
        }

        .fontkecil {
            font-size: 60%;
            vertical-align: top;
            font-style: italic;
        }
        .tanganpointer{ cursor:pointer}

        td {
            white-space: nowrap;
        }
        .previewgambar {
            width: 350px;
            height: 350px;
        }
    </style>

<script type="text/javascript">
    $(function() {
        $("#tglpr").datepicker({              
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2022"
        });
        $( "#penyusutanps" ).focusin(function() {
            $(this).val('');
        });

        $( "#penyusutanps" ).focusout(function() {
            if($(this).val()=='') {
                $(this).val(0);
            }
        });
        $( "#nilaipr" ).focusin(function() {
            $(this).val('');
        });
        $( "#nilaipr" ).focusout(function() {
            if($(this).val()=='') {
                $(this).val(0);
            }
        });

        $( "#hargasi" ).focusin(function() {
            $(this).val('');
        });
        $( "#hargasi" ).focusout(function() {
            if($(this).val()=='') {
                $(this).val(0);
            }
        });

        $("#katid").change(function() {
            var katid   = $(this).val();            
            getJenis(katid);
        });

        $( "#asetpic" ).dialog({
            autoOpen: false,
            height: 600,
            width: 800,
            modal: true
        });
        $( "#opener" ).on( "click", function() {
            $( "#asetpic" ).dialog( "open" );
        });

    });

    function getJenis(katid) {
        if(katid != '') {
		    $.post('<?=site_url()?>/sjaset/asetlengalat/getJenis/'+katid, function(data){
                $('#jenisidj').empty();
                $('#jenisidj').append(data);
            });
        } else {
            $('#jenisidj').empty();
            $('#jenisidj').append('<option value="-1">--Pilih Kategori dahulu--</option>');
        }
    }
</script>
</head>

<body>
    <?php
    menulist();
    ?>
    <form action="<?= site_url() ?>/sjaset/asetlengalat/inputeditproc/<?=$data['ItemID']?>" method='post' id='formin' enctype="multipart/form-data">
        <input type='hidden' name='urlsegment' id='urlsegment' value='<?= $urlsegment ?>' />
        <input type='hidden' name='assetorder' id='assetorder' value='<?=$data['AssetOrder']?>' />
        <br />
        <br />
        <br />
        <table width='400' align='center'>
            <tr>
                <td>
                    <table class='gridtable' width='600'>
                        <thead>
                            <tr>
                                <th colspan='4'>Perlengkapan dan Peralatan</th>
                            </tr>
                        </thead>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Identitas Barang&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                No Aset&nbsp;
                            </td>
                            <td colspan='3'>
                                <span id="assetdisplay"><?= $data['AssetNo'] ?></span>
                                <input type='hidden' name='AssetNo' id='AssetNo' value="<?= $data['AssetNo'] ?>" />
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Kategori&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('katid', $itemkatmaster, 'KatID', 'KatName', $data['KatID'], '', '-Pilih Kategori-', "id='katid'");?>
                            </td>
                            <td align="right">
                                Jenis&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('jenisidj', $itemjenisperlengperalatkatmaster, 'IDJ', 'JenisPerlengPeralatKatName', $data['jenisidj'], '', '-Pilih Jenis-', "id='jenisidj'");?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Perolehan&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Tgl Perolehan&nbsp;
                            </td>
                            <td>
								<input type='text' name='tglpr' size='9' id='tglpr' value="<?= $data['TglPr'] ?>" readonly />
                            </td>
                            <td align="right">
                                No Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='nodokumenpr' size='30' id='nodokumenpr' value="<?= $data['NoDokumenPr'] ?>" />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='nilaipr' size='20' id='nilaipr' value="<?= $data['NilaiPr'] ?>" class='ratakanan' />
                            </td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Posisi&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Penyusutan&nbsp;
                            </td>
                            <td>
								<input type='text' name='penyusutanps' size='3' id='penyusutanps' value="<?= $data['PenyusutanPs'] ?>" class='ratakanan' /> %
							</td>
                            <td align="right">
                                Lokasi&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('lokasiidps', $itemlokasimaster, 'LokasiID', 'LokasiName', $data['LokasiIDPs'], '', '-Pilih Lokasi-', "id='lokasiidps'");?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Divisi&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('divisionidps', $itemdivisionmaster, 'DivisionID', 'DivisionAbbr', $data['DivisionIDPs'], '', '-Pilih Divisi-', "id='divisionidps'");?>
                            </td>
                            <td align="right">
                                Lantai&nbsp;
                            </td>
                            <td>
                                <input type='text' name='lantaips' size='5' id='lantaips' value="<?=$data['LantaiPs']?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="3">
                                Ruangan&nbsp;
                            </td>
                            <td>
                            <input type='text' name='ruanganps' size='20' id='ruanganps' value="<?=$data['RuanganPs']?>" />
                            </td>
                        </tr>
						<tr>
                            <td colspan='4' class='subdata'>
                                Kondisi Saat Ini&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                Penanggung Jawab&nbsp;
                            </td>
                            <td>
<?php
if($data['PenanggungJawabSi']=='') {
?>

<select name='penanggungjawabsi' id='penanggungjawabsi'>
    <option value="">--Pilih Penanggung Jawab--</option>
    <option value="Divisi Umum dan SDM">Divisi Umum dan SDM</option>
    <option value="Divisi Pertanahan dan Hukum">Divisi Pertanahan dan Hukum</option>
    <option value="Divisi Usaha">Divisi Usaha</option>
    <option value="Unit Pemasaran dan Pengelolaan Aset">Unit Pemasaran dan Pengelolaan Aset</option>
</select>
<?php
} else { ?>
<input type='text' name='penanggungjawabsi' size='30' id='penanggungjawabsi' value="<?= $data['PenanggungJawabSi'] ?>" />
<?php } ?>
                            </td>
                            <td align="right">
                                Kondisi&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('kondisikodesi', $kondisikodesi, 'KondisiKodeSi', 'KondisiKodeSiName', $data['KondisiKodeSi'], '', '-Pilih Kondisi-', "id='kondisikodesi'");?>
							</td>
                        </tr>
						<tr>
                            <td align="right" valign="top">
                                Harga&nbsp;
                            </td>
                            <td valign="top">
                                <input type='text' name='hargasi' size='20' id='hargasi' value="<?= $data['HargaSi'] ?>" class='ratakanan' /> 
                            </td>
                            <td align="right" valign="top">
                                Keterangan&nbsp;
                            </td>
                            <td>
								<textarea name="keterangansi" id="keterangansi" rows="4" cols="50"><?= $data['KeteranganSi'] ?></textarea>
							</td>
                        </tr>
                        <tr>
                            <td align="right">
                                File Foto&nbsp;
                            </td>
                            <td colspan="3">
                                <input name="piclocationsi" type="file" id="piclocationsi" />
                                <a id="opener" class="tanganpointer">Lihat Gambar</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <input type='submit' name='submit' value='KEMBALI' />
                    <input type='submit' name='submit' value='SIMPAN' />
                </td>
            </tr>
        </table>
    </form>
    <div id="asetpic" title="Gambar Aset">
        <img src="<?=$pic_url?>publicfolder/asetpic/lenglat/<?=$data['PicLocationSi']?>" width="740"  />
    </div>
    <script>
        // new Spry.Widget.ValidationTextField("nodokumenpr", "none");
        new Spry.Widget.ValidationTextField("nilaipr", "integer", { minValue: "0",useCharacterMasking:true });
        new Spry.Widget.ValidationTextField("hargasi", "integer", { minValue: "0",useCharacterMasking:true });
        new Spry.Widget.ValidationTextField("penyusutanps", "integer", {  minValue: "0",maxValue: "100",useCharacterMasking:true });
        // new Spry.Widget.ValidationSelect("katid");
        // new Spry.Widget.ValidationSelect("jenisidj");
        // new Spry.Widget.ValidationSelect("divisionidps");
        // new Spry.Widget.ValidationSelect("lokasiidps");
        // new Spry.Widget.ValidationTextField("penanggungjawabsi", "none");
        // new Spry.Widget.ValidationSelect("kondisikodesi");
    </script>
    <br />
<br />
<br />
</body>

</html>