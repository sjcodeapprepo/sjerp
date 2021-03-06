<html>

<head>
    <title>Aset Tanah - input</title>
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
        }); //

        $("#tgldokumenpr").datepicker({              
            changeMonth: true,
            changeYear: true,
            yearRange: "1960:2022"
        });

        $("#tgldokumensi").datepicker({              
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

        $( "#catatantambahan" ).dialog({
            autoOpen: false,
            height: 600,
            width: 800,
            modal: true,
            buttons: {
                SIMPAN: function() {
                    var addnotes    = $("#addnotes").val();
                    $("#addnotesinput").val(addnotes);
                    $( this ).dialog( "close" );
                }
            }
        });
    
        $( "#opennotes" ).on( "click", function() {
            $( "#catatantambahan" ).dialog( "open" );
        });

    });
    function addUser() {

    }
</script>
</head>

<body>
    <?php
    menulist();
    ?>
    <form action="<?= site_url() ?>/sjaset/asettanah/inputeditproc/" method='post' id='formin' enctype="multipart/form-data">
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
                                <th colspan='4'>Tanah</th>
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
                                Jenis Dokumen&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('jenisdokumentanahidpr', $itemjenisdokumentanahmaster, 'JenisDokumenTanahID', 'JenisDokumenTanahName', $data['JenisDokumenTanahIDPr'], '', '-Pilih Jenis Dokumen-', "id='jenisdokumentanahidpr'");?>
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Tgl Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='tgldokumenpr' size='9' id='tgldokumenpr' value="<?= $data['TglDokumenPr'] ?>" readonly />
                            </td>
                            <td align="right">
                                No Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='nomordokumenpr' size='30' id='nomordokumenpr' value="<?= $data['NomorDokumenPr'] ?>" />
                            </td>
                        </tr>
						<tr>
                            <td align="right">
                                Luas&nbsp;
                            </td>
                            <td>
								<input type='text' name='luaspr' size='10' id='luaspr' value="<?= $data['LuasPr'] ?>" class='ratakanan' /> M2
                            </td>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
								<input type='text' name='nilaipr' size='14' id='nilaipr' value="<?= $data['NilaiPr'] ?>" class='ratakanan' />
							</td>
                        </tr>
                        <tr>
                            <td align="right">
                                Apresiasi&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='apresiasipr' size='3' id='apresiasipr' value="<?= $data['ApresiasiPr'] ?>" class='ratakanan' />%
							</td>
                        </tr>
                        <tr>
                            <td colspan='4' class='subdata'>
                                Posisi&nbsp;
                            </td>
						</tr>
                        <tr>
                            <td align="right">
                                Lokasi&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='lokasips' size='66' id='lokasips' value="<?= $data['LokasiPs'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Latitude&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='latps' size='20' id='latps' value="<?= $data['LatPs'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Longitude&nbsp;
                            </td>
                            <td colspan="3">
								<input type='text' name='longps' size='20' id='longps' value="<?= $data['LongPs'] ?>" />
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
                            <select name='penanggungjawabsi' id='penanggungjawabsi'>
                                <option value="">--Pilih Penanggung Jawab--</option>
                                <option value="Divisi Umum dan SDM">Divisi Umum dan SDM</option>
                                <option value="Divisi Pertanahan dan Hukum">Divisi Pertanahan dan Hukum</option>
                                <option value="Divisi Usaha">Divisi Usaha</option>
                                <option value="Unit Pemasaran dan Pengelolaan Aset">Unit Pemasaran dan Pengelolaan Aset</option>
                            </select>
								<!-- <input type='text' name='penanggungjawabsi' size='20' id='penanggungjawabsi' value="<?= $data['PenanggungJawabSi'] ?>" /> -->
                            </td>
                            <td align="right">
                                Status&nbsp;
                            </td>
                            <td>
								<?=form_dropdownDB_init('statusidsi', $itemstatuspenguasaanmaster, 'StatusID', 'StatusName', $data['StatusIDSi'], '', '-Pilih Status-', "id='statusidsi'");?>
                            </td>
                        </tr>

                        <tr>
                            <td align="right">
                                Jenis Dokumen&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('jenisdokumentanahidsi', $itemjenisdokumentanahmaster, 'JenisDokumenTanahID', 'JenisDokumenTanahName', $data['JenisDokumenTanahIDSi'], '', '-Pilih Jenis Dokumen-', "id='jenisdokumentanahidsi'");?>                            
                            </td>
                            <td align="right">
                                Peruntukan&nbsp;
                            </td>
                            <td>
                                <?=form_dropdownDB_init('peruntukanidsi', $itemperuntukanmaster, 'PeruntukanID', 'PeruntukanName', $data['PeruntukanIDSi'], '', '-Pilih Jenis Peruntukan-', "id='peruntukanidsi'");?>
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
                                No Dokumen&nbsp;
                            </td>
                            <td>
								<input type='text' name='nodokumensi' size='30' id='nodokumensi' value="<?= $data['NoDokumenSi'] ?>" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                Luas&nbsp;
                            </td>
                            <td>
								<input type='text' name='luassi' size='10' id='luassi' value="<?= $data['LuasSi'] ?>" class='ratakanan' /> M2
                            </td>
                            <td align="right">
                                Nilai&nbsp;
                            </td>
                            <td>
								<input type='text' name='nilaisi' size='20' id='nilaisi' value="<?= $data['NilaiSi'] ?>" class='ratakanan' />
                            </td>
                        </tr>
						<tr>
                            <td align="right" valign="top">
                                Keterangan&nbsp;
                            </td>
                            <td colspan="3">
								<textarea name="keterangansi" id="keterangansi" rows="4" cols="66"><?= $data['KeteranganSi'] ?></textarea>
							</td>
                        </tr>
                        <tr>
                            <td align="right" valign="top">
                                Catatan Tambahan&nbsp;
                            </td>
                            <td colspan="3">
                                <a id="opennotes">Buat Catatan Tambahan</a>
                                <br />
                                <input type='hidden' id="addnotesinput" name='addnotesinput' value="" />
                                <br />
                                <div id="catatantambahan" title="Catatan Tambahan">
                                    <textarea id="addnotes" name="addnotes" rows="20" cols="70"></textarea>
                                </div>
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
        // new Spry.Widget.ValidationTextField("nomordokumenpr", "none");
        // new Spry.Widget.ValidationTextField("luaspr", "integer", { minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("nilaipr", "integer", { minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("apresiasipr", "integer", { minValue: "0",useCharacterMasking:true});
        
        // new Spry.Widget.ValidationTextField("lokasips", "none");
        // new Spry.Widget.ValidationTextField("latps", "real", { useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("longps", "real", { useCharacterMasking:true});
        
        // new Spry.Widget.ValidationTextField("penanggungjawabsi", "none");
        // new Spry.Widget.ValidationSelect("statusidsi");
        // new Spry.Widget.ValidationSelect("jenisdokumentanahidsi");
        // new Spry.Widget.ValidationSelect("peruntukanidsi");

        // new Spry.Widget.ValidationTextField("luassi", "integer", { minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("nilaisi", "integer", { minValue: "0",useCharacterMasking:true});
        // new Spry.Widget.ValidationTextField("keterangansi", "none");
        // new Spry.Widget.ValidationTextField("nodokumensi", "none");

    </script>
    <br />
    <br />
    <br />
</body>

</html>