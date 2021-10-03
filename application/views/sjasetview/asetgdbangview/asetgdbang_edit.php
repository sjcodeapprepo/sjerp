<html>

<head>
    <title>Aset Gedung dan Bangunan - edit</title>
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

        td {
            white-space: nowrap;
        }
    </style>

<script type="text/javascript">
    $(function() {
        $("#katid").change(function() {
            var katid   = $(this).val();            
            getJenis(katid);
        });

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
    });
    
    function getJenis(katid) {
        if(katid != '') {
            $.post('<?=site_url()?>/sjaset/asetgdbang/getJenis/'+katid, function(data){
                $('#jenisgdgbangunanidsi').empty();
                $('#jenisgdgbangunanidsi').append(data);
            });
        } else {
                $('#jenisgdgbangunanidsi').empty();
                $('#jenisgdgbangunanidsi').append('<option value="-1">--Pilih Kategori dahulu--</option>');
            }
    }
</script>
</head>

<body>
    <?php
    menulist();
    ?>
    <form action="<?= site_url() ?>/sjaset/asetgdbang/inputeditproc/<?=$data['ItemID']?>" method='post' id='formin' enctype="multipart/form-data">
        <input type='hidden' name='urlsegment' id='urlsegment' value='<?= $urlsegment ?>' />
        <input type='hidden' name='assetorder' id='assetorder' value='<<?=$data['AssetOrder']?>' />
        <br />
        <br />
        <br />
        <table width='400' align='center'>
            <tr>
                <td>
                    <table class='gridtable' width='600'>
                        <thead>
                            <tr>
                                <th colspan='4'>Gedung dan Bangunan</th>
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
								&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Kategori&nbsp;
                            </td>
                            <td colspan="3">
								<?=form_dropdownDB_init('katid', $itemkatmaster, 'KatID', 'KatName', $data['KatID'], '', '-Pilih Kategori-', "id='katid'");?>
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
                                Luas Bangunan&nbsp;
                            </td>
                            <td>
                                <input type='text' name='luasbangunanpr' size='20' id='luasbangunanpr' value="<?= $data['LuasBangunanPr'] ?>" class='ratakanan' />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nilaiperolehanpr' size='20' id='nilaiperolehanpr' value="<?= $data['NilaiPerolehanPr'] ?>" class='ratakanan' />
                            </td>
                            <td align="right">
                                Jenis&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('jenisperolehanidpr', $itemjenisperolehanmaster, 'JenisPerolehanID', 'JenisPerolehanName', $data['JenisPerolehanIDPr'], '', '-Pilih Kategori-', "id='jenisperolehanidpr'");?>
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Mitra Kerjasama&nbsp;
                            </td>
                            <td>
                                <input type='text' name='mitrakerjasamapr' size='30' id='mitrakerjasamapr' value="<?= $data['MitraKerjasamaPr'] ?>" />
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
                                Tanggal Dokumen&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='tgldokumenpr' size='9' id='tgldokumenpr' value="<?= $data['TglDokumenPr'] ?>" readonly />
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
                            <td colspan="3">
								<input type='text' name='penyusutanps' size='10' id='penyusutanps' value="<?= $data['PenyusutanPs'] ?>" class='ratakanan' /> %
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Lokasi&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='lokasips' size='30' id='lokasips' value="<?= $data['LokasiPs'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Berdiri diatas tanah&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='berdiriatastanahps' size='30' id='berdiriatastanahps' value="<?= $data['BerdiriAtasTanahPs'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Latitude&nbsp;
                            </td>
                            <td>
								<input type='text' name='latps' size='10' id='latps' value="<?= $data['LatPs'] ?>" />
                            </td>
                            <td align="right">
                                Longitude&nbsp;
                            </td>
                            <td>
								<input type='text' name='longps' size='10' id='longps' value="<?= $data['LongPs'] ?>" />
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
								<input type='text' name='penanggungjawabsi' size='20' id='penanggungjawabsi' value="<?= $data['PenanggungJawabSi'] ?>" />
                            </td>
                            <td align="right">
                                Jenis Perolehan&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('jenisperolehanidsi', $itemjenisperolehanmaster, 'JenisPerolehanID', 'JenisPerolehanName', $data['JenisPerolehanIDSi'], '', '-Pilih Jenis Perolehan-', "id='jenisperolehanidsi'");?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Mitra Kerjasama&nbsp;
                            </td>
                            <td>
                                <input type='text' name='mitrakerjasamasi' size='30' id='mitrakerjasamasi' value="<?= $data['MitraKerjasamaSi'] ?>" />
                            </td>
                            <td align="right">
                                No Dokumen&nbsp;
                            </td>
                            <td>
                                <input type='text' name='nodokumensi' size='20' id='nodokumensi' value="<?= $data['NoDokumenSi'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Tgl Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='tgldokumensi' size='9' id='tgldokumensi' value="<?= $data['TglDokumenSi'] ?>" readonly />
                            </td>
                            <td align="right">
                                Jenis Gedung / Bangunan&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('jenisgdgbangunanidsi', $itemjenisbangunanmaster, 'JenisGdgBangunanID', 'JenisGdgBangunanName', $data['JenisGdgBangunanIDSi'], '', '-Pilih Jenis Gedung/Bangunan-', "id='jenisgdgbangunanidsi'");?> 
                            </td>                            
                        </tr>
						<tr>
                        <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
								<input type='text' name='nilaisi' size='20' id='nilaisi' value="<?= $data['NilaiSi'] ?>" class='ratakanan' />
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
    <script>
        new Spry.Widget.ValidationTextField("nodokumenpr", "none");
        new Spry.Widget.ValidationTextField("nilaipr", "integer", {
            minValue: "0",useCharacterMasking:true
        });
        new Spry.Widget.ValidationTextField("nilaisi", "integer", {
            minValue: "0",useCharacterMasking:true
        });
        new Spry.Widget.ValidationTextField("penyusutanps", "integer", {
            minValue: "0",maxValue: "100",useCharacterMasking:true
        });
        new Spry.Widget.ValidationSelect("katid");
        new Spry.Widget.ValidationSelect("kondisikodesi");
    </script>
</body>

</html>