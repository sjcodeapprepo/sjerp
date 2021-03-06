<html>

<head>
    <title>Aset Elektronika dan Mesin - input</title>
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
        $("#tglpr").datepicker({              
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2022"
        });

        $("#katid").change(function() {
            var katid   = $(this).val();            
            getJenis(katid);
        });

        $( "#penyusutanpr" ).focusin(function() {
            $(this).val('');
        });
        $( "#penyusutanpr" ).focusout(function() {
            if($(this).val()=='') {
                $(this).val(0);
            }
        });
    });

    function getJenis(katid) {
        if(katid != '') {
            $.post('<?=site_url()?>/sjaset/asetgelmes/getJenis/'+katid, function(data){
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
    <form action="<?= site_url() ?>/sjaset/asetgelmes/inputeditproc/" method='post' id='formin' enctype="multipart/form-data">
        <input type='hidden' name='urlsegment' id='urlsegment' value='<?= $urlsegment ?>' />
        <br />
        <br />
        <br />
        <table width='400' align='center'>
            <tr>
                <td>
                    <table class='gridtable' width='600'>
                        <thead>
                            <tr>
                                <th colspan='4'>Elektronika dan Mesin</th>
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
                            <td>
								<?=form_dropdownDB_init('katid', $itemkatmaster, 'KatID', 'KatName', $data['KatID'], '', '-Pilih Kategori-', "id='katid'");?>
                            </td>
                            <td align="right">
                                Jenis&nbsp;
                            </td>
                            <td>
                                <select name="jenisidj" id="jenisidj">
                                    <option value="-1">--Pilih Kategori dahulu--</option>
                                </select>
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
                            <td colspan="3">
								<input type='text' name='tglpr' size='9' id='tglpr' value="<?= $data['TglPr'] ?>" readonly />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                No Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='nodokumenpr' size='30' id='nodokumenpr' value="<?= $data['NoDokumenPr'] ?>" />
                            </td>
                            <td align="right">
                                Lokasi&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('lokasiidpr', $itemlokasimaster, 'LokasiID', 'LokasiName', $data['LokasiIDPr'], '', '-Pilih Lokasi-', "id='lokasiidpr'");?>
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
								<input type='text' name='nilaipr' size='20' id='nilaipr' value="<?= $data['NilaiPr'] ?>" class='ratakanan' />
                            </td>
                            <td align="right">
                                Penyusutan&nbsp;
                            </td>
                            <td>
								<input type='text' name='penyusutanpr' size='3' id='penyusutanpr' value="0" class='ratakanan' /> %
							</td>
                        </tr>
						<tr>
                            <td colspan='4' class='subdata'>
                                Posisi&nbsp;
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
                                Penanggung Jawab&nbsp;
                            </td>
                            <td>
                            <select name='penanggungjawabps' id='penanggungjawabps'>
    <option value="">--Pilih Penanggung Jawab--</option>
    <option value="Divisi Umum dan SDM">Divisi Umum dan SDM</option>
    <option value="Divisi Pertanahan dan Hukum">Divisi Pertanahan dan Hukum</option>
    <option value="Divisi Usaha">Divisi Usaha</option>
    <option value="Unit Pemasaran dan Pengelolaan Aset">Unit Pemasaran dan Pengelolaan Aset</option>
</select>
								<!-- <input type='text' name='penanggungjawabps' size='30' id='penanggungjawabps' value="<?= $data['PenanggungJawabPs'] ?>" /> -->
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Kondisi&nbsp;
                            </td>
                            <td colspan='3'>
                                <?=form_dropdownDB_init('kondisikodesi', $kondisikodesi, 'KondisiKodeSi', 'KondisiKodeSiName', $data['KondisiKodeSi'], '', '-Pilih Kondisi-', "id='kondisikodesi'");?>
							</td>
                        </tr>
						<tr> <!-- ////////////////////////////=============================//////////////////////////////////// -->
                            <td colspan='4'  class='subdata'>
                                Kondisi Saat Ini&nbsp;
                            </td>
						</tr>
						<tr>
                            <td align="right">
                                Harga&nbsp;
                            </td>
                            <td>
                                <input type='text' name='hargasi' size='20' id='hargasi' value="<?= $data['HargaSi'] ?>" class='ratakanan' /> 
                            </td>
                            <td align="right">
                                File Foto&nbsp;
                            </td>
                            <td>
                                <input name="piclocationsi" type="file" id="piclocationsi" />
                            </td>
                        </tr>
						<tr>
                            <td align="right" valign="top">
                                Keterangan&nbsp;
                            </td>
                            <td colspan="3">
								<textarea name="keterangansi" id="keterangansi" rows="4" cols="50"></textarea>
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
        // new Spry.Widget.ValidationTextField("nodokumenpr", "none");
        // new Spry.Widget.ValidationTextField("nilaipr", "integer", { minValue: "0",useCharacterMasking:true });
        // new Spry.Widget.ValidationTextField("hargasi", "integer", {minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("penyusutanpr", "integer", {minValue: "0",maxValue: "100",useCharacterMasking:true });
        // new Spry.Widget.ValidationSelect("katid");
        // new Spry.Widget.ValidationSelect("jenisidj");
        // new Spry.Widget.ValidationSelect("lokasiidpr");
        // new Spry.Widget.ValidationSelect("kondisikodesi");
        // new Spry.Widget.ValidationSelect("divisionidps");
        // new Spry.Widget.ValidationTextField("penanggungjawabps", "none");
    </script>
</body>

</html>