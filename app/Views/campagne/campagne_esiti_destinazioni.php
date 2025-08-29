<!-- array(4) { ["title"]=> string(33) "Destinazioni esiti della campagna" 
    
    
["esiti_destinazioni"]=> array(1) { [0]=> array(21) 
    { ["campId_Fk"]=> string(1) "2" ["Idesito_Fk"]=> string(1) "2" ["campId_Fk_dest"]=> string(1) "4" ["idUtente_Fk_dest"]=> NULL 
        ["Idesito_Fk_dest"]=> NULL 
        ["spostimmediato"]=> string(1) "0" 
        ["giorni"]=> NULL ["bloccocampagnaorigine"]=> string(1) "0" 
        ["idUtente_Fk_modifica"]=> string(2) "15" 
        ["data_modifica"]=> string(19) "2025-06-11 17:42:38" 
        ["campidorig"]=> string(1) "2" 
        ["campnomeorig"]=> string(19) "Schedatura Webvista" 
        ["esitoidorig"]=> string(1) "2" 
        ["esitonomeorig"]=> string(8) "Positivo" 
        ["campiddest"]=> string(1) "4" 
        ["campnomedest"]=> string(16) "Vendita Webvista" 
        ["esitoiddest"]=> NULL 
        ["esitonomedest"]=> NULL 
        ["idutentedest"]=> NULL 
        ["nomeutentedest"]=> NULL 
        ["nomeutentemod"]=> string(15) "Walter Prazzoli" } } 
        
        ["esiti_campagne"]=> array(2) { 
            [0]=> array(4) { 
            ["campid_Fk"]=> string(1) "2" 
            ["campNome"]=> string(19) "Schedatura Webvista" 
            ["nomeEsito"]=> string(12) "Non risponde" 
            ["idEsito_Fk"]=> string(1) "1" } 
            
            [1]=> array(4) { ["campid_Fk"]=> string(1) "2" ["campNome"]=> string(19) "Schedatura Webvista" ["nomeEsito"]=> string(8) "Positivo" ["idEsito_Fk"]=> string(1) "2" } } 
            
            
            ["esitinonassociati"]=> array(3) { ["dati"]=> array(0) { } ["campId"]=> string(1) "2" ["campNome"]=> string(19) "Schedatura Webvista" } } -->
<style>
    th,td
    {
        text-align:center;
    }
</style>
<script>
	$(function() 
	{
		$('#table_campagne_esiti_destinazioni').DataTable({
			language: {
				url: "https://cdn.datatables.net/plug-ins/2.1.8/i18n/it-IT.json"
			},
			columnDefs: [{
				targets: -1, 
				orderable: false
			}],
			"searching": true,
			"paging": true,
			"info": false
			});
	});

	//Cancellazione campagne esiti destinazioni
	function deleteCED(campId,idEsito,campIdDest)
	{
		$.ajax({
            url: '/DeleteCampagneEsitiDestinazioni/' + campId + '/' + idEsito + '/' + campIdDest,
            method: "GET",
            data: {
            },
            success: function(res) {
				location.href = "/CampagneEsitiDestinazioni/" + campId + "/" + idEsito;
            },
            error: function(err) {
                console.log(err);
            },
        });
	}

    function insertCED(campId,idEsito)
    {
        $('#lblerroresitidestinazioni').hide();
        $('#lblerroresitidestinazioni').removeClass('alert-success');
        $('#lblerroresitidestinazioni').addClass('alert-danger');

        if($('#campiddest__ins').val() == '')
        {
            $('#lblerroresitidestinazioni').html("Selezionare la campagna di destinazione");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        if($('#spost_ins').val() == '')
        {
            $('#lblerroresitidestinazioni').html("Selezionare lo spostamento immediato");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        if($('#giornidest_ins').val() == '')
        {
            $('#lblerroresitidestinazioni').html("Indicare giorni di destinazione");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        if($('#bloccocamporig_dest').val() == '')
        {
            $('#lblerroresitidestinazioni').html("Selezionare blocco campagna origine");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        $('#type').val('INS');
        
        $.ajax({
            url: '/UpdateInsertCampagneEsitiDestinazioni',
            method: "POST",
            data: $('#destinazioni_esiti').serialize(),
            success: function(res) {
				location.href = "/CampagneEsitiDestinazioni/" + campId + "/" + idEsito;
            },
            error: function(err) {
                console.log(err);
            },
        });
        
    }

    function saverow(row)
    {
        $('#lblerroresitidestinazioni').hide();
        $('#lblerroresitidestinazioni').removeClass('alert-success');
        $('#lblerroresitidestinazioni').addClass('alert-danger');

        if($('#cndm_' + row).val() == '')
        {
            $('#lblerroresitidestinazioni').html("Selezionare la campagna di destinazione");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        if($('#smod_' + row).val() == '')
        {
            $('#lblerroresitidestinazioni').html("Selezionare lo spostamento immediato");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        if($('#giornitxt_' + row).val() == '')
        {
            $('#lblerroresitidestinazioni').html("Indicare giorni di destinazione");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        if($('#bmod_' +row).val() == '')
        {
            $('#lblerroresitidestinazioni').html("Selezionare blocco campagna origine");
            $('#lblerroresitidestinazioni').show();
            return false;
        }

        $('#idmod').val(row);
        $('#type').val('UPD');
        
        $.ajax({
            url: '/UpdateInsertCampagneEsitiDestinazioni',
            method: "POST",
            data: $('#destinazioni_esiti').serialize(),
            success: function(res) {
				location.href = "CampagneEsitiDestinazioni/<?=$campid?>/<?=$esito['esito']['idEsito']?>";
            },
            error: function(err) {
                console.log(err);
            },
        });
    }
</script>
<div align="center"><h1><?=strtoupper($title)?></h1></div>
<div style="width:90%" id="campagne_esiti_destinazioni">
    <br><br>
    <?=form_open('CampagneEsitiDestinazioni/' . $campid . '/' . $esito['esito']['idEsito'],array('id' => 'destinazioni_esiti')); ?>
            <?= csrf_field() ?>
            <input type="hidden" name="campid" value="<?=$campid?>">
            <input type="hidden" name="esitoid" value="<?=$esito['esito']['idEsito']?>">
            <input type="hidden" name="type" id="type" value="">
            <input type="hidden" name="idmod" id="idmod" value="">

            <table class="col-lg-12" id="table_campagne_esiti_destinazioni">
                <thead>
                    <th style="border: 1px solid;">Campagna</th>
                    <th style="border: 1px solid;">Esito</th>
                    <th style="border: 1px solid;">Camp dest</th>
                    <th style="border: 1px solid;">Utente dest</th>
                    <th style="border: 1px solid;">Esito dest</th>
                    <th style="border: 1px solid;">Spost immediato</th>
                    <th style="border: 1px solid;">Giorni</th>
                    <th style="border: 1px solid;">Blocco camp origine</th>
                    <th style="border: 1px solid;border-right:0;">Azioni</th>
                </thead>
                <tbody>
                        <?php if(sizeof($esiti_destinazioni) > 0):
                            $r = 1;
                            foreach ($esiti_destinazioni as $es): ?>
                                <tr>
                                    <td style="border: 1px solid;">
                                        <span id="campn_<?=$r?>"><?=$es['campnomeorig'];?></span>
                                    </td>
                                    <td style="border: 1px solid;"><?=$es['esitonomeorig']?></td>
                                    <td style="border: 1px solid;width:15%;">
                                        <input type="hidden" id="campdest_<?=$r?>" name="campdest_<?=$r?>" value="<?=$es['campiddest']?>">
                                        <span id="cndv_<?=$r?>"><?=$es['campnomedest']?></span>
                                        <select id="cndm_<?=$r?>" class="form-control" style="display:none;" name="campiddest_<?=$r?>" onchange="changeCampDestUpdate(<?=$r?>)">
                                            <option value="">Seleziona...</option>
                                            <?php foreach($campagne['campagne'] AS $camp):?>
                                                <?php if($campid != $camp['campId']): ?>
                                                    <option value="<?=$camp['campId']?>" <?=$camp['campId'] == $es['campiddest'] ? " selected='selected'" : "" ?>><?=$camp['campNome']?></option> 
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td style="border: 1px solid;width:15%;">
                                        <span id="nud_<?=$r?>"><?=!empty($es['nomeutentedest']) ? $es['nomeutentedest'] : "Non selezionato"?></span>
                                        <select id="nudm_<?=$r?>" class="form-control" style="display:none;" name="utenteiddest_<?=$r?>">
                                            <option value="">Non definito</option>
                                        </select>
                                    </td>
                                    <td style="border: 1px solid;width:15%;">
                                        <span id="esn_<?=$r?>"><?=$es['esitonomedest'] ? $es['esitonomedest'] : "Non selezionato"?></span>
                                        <select id="esnm_<?=$r?>" class="form-control" style="display:none;" name="esitoiddest_<?=$r?>">
                                            <option value="">Non definito</option>
                                        </select>
                                    </td>
                                    <td style="border: 1px solid;">
                                        <span id="spost_<?=$r?>"><?=$es['spostimmediato'] == 1 ? "SI" : "NO" ?></span>
                                        <select id="smod_<?=$r?>" class="form-control" style="display:none;" name="spostdest_<?=$r?>">
                                            <option value="">Seleziona...</option>
                                            <option value="1" <?=$es['spostimmediato'] == 1 ? " selected='selected'" : "" ?>>SI</option>
                                            <option value="2" <?=$es['spostimmediato'] == 0 ? " selected='selected'" : "" ?>>NO</option>
                                        </select>
                                    </td>
                                    <td style="border: 1px solid;">
                                        <span id="giorni_<?=$r?>"><?=$es['giorni']?></span>
                                        <input type="number" class="form-control" id="giornitxt_<?=$r?>" name="giornidest_<?=$r?>" style="display:none;" value="<?=!empty($es['giorni']) ? $es['giorni'] : ""?>">
                                    </td>
                                    <td style="border: 1px solid;">
                                        <span id="blocco_<?=$r?>"><?=$es['bloccocampagnaorigine'] == 1 ? "SI" : "NO" ?></span>
                                        <select id="bmod_<?=$r?>" class="form-control" style="display:none;" name="bloccodest_<?=$r?>">
                                            <option value="">Seleziona...</option>
                                            <option value="1" <?=$es['bloccocampagnaorigine'] == 1 ? " selected='selected'" : "" ?>>SI</option>
                                            <option value="2" <?=$es['bloccocampagnaorigine'] == 0 ? " selected='selected'" : "" ?>>NO</option>
                                        </select>
                                    </td>
                                    <td style="border: 1px solid;border-left:0;width:10%;">
                                        <a href="javascript:void(0)" id="edit_<?=$r?>" onclick="editrow('<?=$r?>')" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                        <a href="javascript:void(0)" onclick="saverow('<?=$r?>')" class="btn btn-success"><i class="material-icons">save</i></a>
                                        <!-- ELIMINA -->
                                        <a href="javascript:void(0)" onclick="deleteCED(<?=$es['campidorig']?>,<?=$es['esitoidorig']?>,<?=$es['campiddest']?>)" class='btn btn-danger'><i class="material-icons">clear</i></a>
                                    </td>
                                </tr>
                            <?php 
                                $r++;
                            endforeach; ?>
                        <?php endif; ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$esiti_campagne[0]['campNome'] ?? "";?></td>
                                <td style="border: 1px solid;"><?=$esito['esito']['nomeEsito'];?></td>
                                <td style="border: 1px solid;">
                                    <select id="campiddest__ins" name="campiddest__ins" class="form-control" onchange="changeCampDestInsert()">
                                        <option value="">Seleziona...</option>
                                        <?php foreach($campagne['campagne'] AS $camp):?>
                                            <?php if($campid != $camp['campId']): ?>
                                                <option value="<?=$camp['campId']?>"><?=$camp['campNome']?></option> 
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="border: 1px solid;width:15%;">
                                    <select id="idutente_ins" name="idutente_ins" class="form-control">
                                            <option value="">Non definito</option>
                                    </select>
                                </td>
                                <td style="border: 1px solid;width:15%;">
                                    <select id="idesito_ins" name="idesito_ins" class="form-control">
                                            <option value="">Non definito</option>
                                    </select>
                                </td>
                                <td style="border: 1px solid;">
                                    <select id="spost_ins" name="spost_ins" class="form-control">
                                        <option value="">Seleziona...</option>
                                        <option value="1">SI</option>
                                        <option value="2">NO</option>
                                    </select>
                                </td>
                                <td style="border: 1px solid;">
                                    <input type="number" class="form-control" id="giornidest_ins" name="giornidest_ins">
                                </td>
                                <td style="border: 1px solid;">
                                    <select id="bloccocamporig_dest" class="form-control" name="bloccocamporig_dest">
                                            <option value="">Seleziona...</option>
                                            <option value="1">SI</option>
                                            <option value="2">NO</option>
                                    </select>
                                </td>
                                <td style="border: 1px solid;border-left:0;">
                                    <!-- INSERISCI -->
                                    <a href="javascript:void(0)" onclick="insertCED(<?=$campid?>,<?=$esito['esito']['idEsito']?>)" class='btn btn-success'><i class="material-icons">save</i></a>
                                </td>

                            </tr>
                </tbody>
            </table>
            <?=form_close();?>
            <label class="alert alert-danger" id="lblerroresitidestinazioni" style="display:none;"></label>
        <?php	
    ?>
</div>

<script>
    function editrow(row)
    {
        $('[id^="campn"]').each(function() 
        {
            id = $(this).attr('id').replace('campn_','');
            $('#cndv_' + id).show();
            $('#nud_' + id).show();
            $('#esn_' + id).show();
            $('#spost_' + id).show();
            $('#giorni_' + id).show();
            $('#blocco_' + id).show();
            $('#cndm_' + id).hide();
            $('#nudm_' + id).hide();
            $('#esnm_' + id).hide();
            $('#smod_' + id).hide();
            $('#giornitxt_' + id).hide();
            $('#bmod_' + id).hide();
            $('#edit_' + id).show();
        });

        $('#cndv_' + row).hide();
        $('#nud_' + row).hide();
        $('#esn_' + row).hide();
        $('#spost_' + row).hide();
        $('#giorni_' + row).hide();
        $('#blocco_' + row).hide();
        $('#cndm_' + row).show();
        $('#nudm_' + row).show();
        $('#esnm_' + row).show();
        $('#smod_' + row).show();
        $('#giornitxt_' + row).show();
        $('#bmod_' + row).show();
        $('#edit_' + row).hide();

        campiddest = $('#campdest_' + row).val();
        //chiamata AJAX per prendere gli utenti e esiti della campagna 
        $.ajax({
            url: '/getUtentiEsitiCampagnaAjax/' + campiddest,
            method: "GET",
            data: {
            },
            // {"esiti_campagne":[{"campid_Fk":"4","campNome":"Vendita Webvista","nomeEsito":"Non risponde","idEsito_Fk":"1"}
            // ,{"campid_Fk":"4","campNome":"Vendita Webvista","nomeEsito":"Positivo vendita","idEsito_Fk":"3"}]


            // ,"esitinonassociati":{"dati":[{"idEsito":"2","nomeEsito":"Positivo schedatura"}],
            // "campId":"4","campNome":"Vendita Webvista"},
            
            // "campagne_utenti":[{"campId":"4","campNome":"Vendita Webvista","idUtente_Fk":"4","utente":"prova7 prova7"}
            // ,{"campId":"4","campNome":"Vendita Webvista","idUtente_Fk":"16","utente":"Prova wp 10 prova wp 10"}]
            
            
            // ,"utentinonassociati":{"dati":[],"campId":"4","campNome":"Vendita Webvista"}}

            success: function(res) {
				utenti = JSON.parse(res)['campagne_utenti'];
                esiti = JSON.parse(res)['esiti_campagne'];

                $('#nudm_' + row).empty();
                $('#nudm_' + row).append($('<option>', 
                {
                        value: "",
                        text: "Seleziona..."
                }));

                $.each(utenti,function()
                {
                    $('#nudm_' + row).append($('<option>', 
                    {
                        value: $(this)[0]['idUtente_Fk'],
                        text: $(this)[0]['utente']
                    }));
                });

                $('#esnm_' + row).empty();
                $('#esnm_' + row).append($('<option>', 
                {
                        value: "",
                        text: "Seleziona..."
                }));

                $.each(esiti,function()
                {
                    $('#esnm_' + row).append($('<option>', 
                    {
                        value: $(this)[0]['idEsito_Fk'],
                        text: $(this)[0]['nomeEsito']
                    }));
                });
            },
            error: function(err) { 
                console.log(err);
            },
        });
    }

    //Cambio campagna dest insert
    function changeCampDestInsert()
    {
        campiddestins = $('#campiddest__ins').val();

        if(campiddestins != '')
        {
            $.ajax({
            url: '/getUtentiEsitiCampagnaAjax/' + campiddestins,
            method: "GET",
            data: {
            },
            success: function(res) {
				utenti = JSON.parse(res)['campagne_utenti'];
                esiti = JSON.parse(res)['esiti_campagne'];

                $('#idutente_ins').empty();
                $('#idutente_ins').append($('<option>', 
                {
                        value: "",
                        text: "Seleziona..."
                }));

                $.each(utenti,function()
                {
                    $('#idutente_ins').append($('<option>', 
                    {
                        value: $(this)[0]['idUtente_Fk'],
                        text: $(this)[0]['utente']
                    }));
                });

                $('#idesito_ins').empty();
                $('#idesito_ins').append($('<option>', 
                {
                        value: "",
                        text: "Seleziona..."
                }));

                $.each(esiti,function()
                {
                    $('#idesito_ins').append($('<option>', 
                    {
                        value: $(this)[0]['idEsito_Fk'],
                        text: $(this)[0]['nomeEsito']
                    }));
                });
            },
                error: function(err) { 
                    console.log(err);
                },
            });
        }
    }

    //Cambio campagna dest update
    function changeCampDestUpdate(row)
    {
        campiddestupd = $('#cndm_' + row).val();

        if(campiddestupd != '')
        {
            //chiamata AJAX per prendere gli utenti e esiti della campagna 
            $.ajax({
                url: '/getUtentiEsitiCampagnaAjax/' + campiddestupd,
                method: "GET",
                data: {
                },

                success: function(res) {
                    utenti = JSON.parse(res)['campagne_utenti'];
                    esiti = JSON.parse(res)['esiti_campagne'];

                    $('#nudm_' + row).empty();
                    $('#nudm_' + row).append($('<option>', 
                    {
                            value: "",
                            text: "Seleziona..."
                    }));

                    $.each(utenti,function()
                    {
                        $('#nudm_' + row).append($('<option>', 
                        {
                            value: $(this)[0]['idUtente_Fk'],
                            text: $(this)[0]['utente']
                        }));
                    });

                    $('#esnm_' + row).empty();
                    $('#esnm_' + row).append($('<option>', 
                    {
                            value: "",
                            text: "Seleziona..."
                    }));

                    $.each(esiti,function()
                    {
                        $('#esnm_' + row).append($('<option>', 
                        {
                            value: $(this)[0]['idEsito_Fk'],
                            text: $(this)[0]['nomeEsito']
                        }));
                    });
                },
                error: function(err) { 
                    console.log(err);
                },
            });
        }
    }
</script>
