
<style>
    .row
    {
        margin-top:15px !important;
    }

    .custom-checkbox {
    width: 20px; /* Set your desired width */
    height: 20px; /* Set your desired height */
    /* Optional: Adjust appearance */
    /* appearance: none; /* Remove default styling */
    border: 2px solid #000; /* Add border */
    border-radius: 4px; /* Optional: rounded corners */
    cursor: pointer; /* Change cursor on hover */
}
</style>
<br>
<?=form_open('',array('id' => 'modify_esito_contatto')); ?>
    <input name="campId" type="hidden" value="<?= $campId ?>">
    <input id="cont_id_update" name="cont_id_update" type="hidden">

     <div class="row">
        <div class="col-lg-6">
            <div class="row">
                    <div class="col-lg-2" style="padding-left:0;">
                        <input type="hidden" id="data_ricontatto" name="data_ricontatto">
                        Data ricontatto<input id="data_ricontatto_cal" type="text" class="form-control col-lg-10" value="" autocomplete="off">
                    </div>
                    <div class="col-lg-2">
                        Ora ricontatto
                        <select name="ora_ricontatto" id="ora_ricontatto" class="form-control">
                            <option value="">HH:MM</option>
                            <?php for($h=8;$h < 21;$h++): ?>
                                <option value="<?=substr("00" . $h,-2)?>:00" <?= !empty($cc['data_ricontatto']) && date('H:i',strtotime($cc['data_ricontatto'])) == (substr("00" . $h,-2) . ":00") ? " selected='selected'" : "" ?>><?=substr("00" . $h,-2)?>:00</option>
                                <option value="<?=substr("00" . $h,-2)?>:30" <?= !empty($cc['data_ricontatto']) && date('H:i',strtotime($cc['data_ricontatto'])) == (substr("00" . $h,-2) . ":30") ? " selected='selected'" : "" ?>><?=substr("00" . $h,-2)?>:30</option>
                            <?php endfor; ?>
                        </select>
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-6" style="padding-left:0;">
                    Invio presentazione&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="invio_presentazione" id="invio_presentazione" value="1" class="custom-checkbox" <?=!empty($cc['invio_presentazione']) && $cc['invio_presentazione'] == 1 ? " checked='checked'" : "" ?>>
                    <input type="hidden" name="inviata_presentazione" id="inviata_presentazione" value="<?=!empty($cc['invio_presentazione']) && $cc['invio_presentazione'] == 1 ? "1" : "2"?>">
                    <!-- <input type="button" class="btn btn-primary btn-md" value="Invia presentazione" onclick="invia_presentazione()">
                    <label class="alert alert-success" id="esito_invio_pres" style="margin-left:30px;display:none;">Presentazione inviata correttamente</label>
                    <input type="hidden" id="inviata_presentazione" name="inviata_presentazione" value=""> -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10" style="padding-left:0;">
                    Link Google Calendar <input type="text" class="form-control" name="link_google" id="link_google" autocomplete="off" value="<?=!empty($cc['linkGoogleCalendar']) ? $cc['linkGoogleCalendar'] : "" ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4" style="padding-left:0;">
                    <?php if(sizeof($products_camp) > 0): ?> 
                        Prodotto <select id="prodotto" name="prodId_Fk" class="form-control">
                                        <option value="">Seleziona...</option>
                                        <?php foreach($products_camp as $product): ?>
                                            <option value="<?=$product['prodId']?>" <?=!empty($cc['prodId_Fk']) && $cc['prodId_Fk'] == $product['prodId'] ? " selected='selected'" : "" ?>><?=$product['nome']?></option>
                                        <?php endforeach; ?>
                                 </select>
                    <?php else: ?>
                        Nessun macro prodotto associato alla campagna
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4" style="padding-left:0;">
                    Servizio digitale <select id="servizio_digitale" name="servizio_digitale" class="form-control">
                                <option value="">Seleziona...</option>
                                <option value="S1" <?=!empty($cc['servizio_digitale']) && $cc['servizio_digitale'] == "S1" ? " selected='selected'" : "" ?>>S1</option>
                                <option value="S2" <?=!empty($cc['servizio_digitale']) && $cc['servizio_digitale'] == "S2" ? " selected='selected'" : "" ?>>S2</option>
                                <option value="S3" <?=!empty($cc['servizio_digitale']) && $cc['servizio_digitale'] == "S3" ? " selected='selected'" : "" ?>>S3</option>
                            </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4" style="padding-left:0;">
                Esito<select id="esito_update_campagna" name="id_esito_update_campagna" class="form-control" onchange="scelta = $('#esito_update_campagna option:selected').text();if(scelta.toLowerCase().substr(0,3) == 'app'){$('#crea_app').show();$('#successModal').modal('show');}else{$('#agg_esito').show();}">
                    <option value="">Seleziona...</option>
                    <?php if(sizeof($esiti_campagna) > 0): ?>
                        <?php foreach($esiti_campagna as $esito_campagna): ?>
                            <option value="<?=$esito_campagna['idEsito']?>" <?=!empty($cc['Idesito_Fk']) && $cc['Idesito_Fk'] == $esito_campagna['idEsito'] ? " selected='selected'" : "" ?>><?=$esito_campagna['nomeEsito']?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                </div>
                <?php if(sizeof($appointment) > 0): ?>
                    <div id="link_app" style="margin-top:25px;">
                        <a href="javascript:void(0)" onclick="$('#crea_app').show();$('#successModal').modal('show');">Visualizza l'appuntamento per il venditore</a>
                    </div>
                <?php endif; ?>
            </div>                      
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-11" style="padding-left:0;">
                    Note <textarea name="note" id="note" class="form-control" rows="5"><?=!empty($cc['note']) ? $cc['note'] : ""?></textarea>
                </div>
            </div>
            <div class="row" id="agg_esito" style="display:none;">
                <br>
                <input type="button" class="btn btn-primary btn-lg" value="Aggiorna" onclick="aggiorna_esito()">
                <br><br>
                <div id="esito_contatto_campagna" class="col-lg-4 alert alert-success" style="display:none;"></div>
            </div>
        </div>
    </div>
             
<?=form_close();?>

<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white bg-success">
                <h5 class="modal-title" id="successModalLabel">Appuntamento per venditore</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align:center;">
                <?php if(sizeof($camp_vendita) > 0 && !empty($macro_prod) ): ?>
                            <?=form_open('',array('id' => 'appointment')); ?>
                                <input id="id_app" name="id_app" type="hidden" value="<?=!empty($appointment[0]['idApp']) ? $appointment[0]['idApp'] : ""?>">
                                <input id="cont_id_app" name="cont_id_app" type="hidden">
                                <input id="esito_sel_app" name="esito_sel_app" type="hidden">
                                <div class="row" style="margin-left:30px;">
                                    Campagna: <select id="camp_vdt" name="camp_vendita" class="form-control col-lg-10 col-lg-offset-1" onchange="caricaVenditori($(this).val())">
                                        <option value="">Seleziona...</option>
                                        <?php foreach($camp_vendita as $campvdt): ?> 
                                                <option value="<?=$campvdt['campId']?>" <?=!empty($appointment[0]['campid_Fk_vdt']) && $appointment[0]['campid_Fk_vdt'] == $campvdt['campId'] ? " selected='selected'" : "" ?>><?=$campvdt['campNome']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="row" style="margin-left:30px;">
                                    Venditore: <select id="vend" name="venditore" class="form-control">
                                        <option value="">Seleziona la campagna</option>
                                        <?=!empty($appointment[0]['nome_cognome_vdt']) ? "<option selected='selected' value='" . $appointment[0]['idUtente_Fk_ext'] . "'>" . $appointment[0]['nome_cognome_vdt'] . "</option>" : "" ?>
                                    </select>
                                </div>
                                <div class="row" style="margin-left:30px;">
                                    <div class="col-lg-4" style="padding-left:0;margin-left:30px;">
                                        <input type="hidden" id="data_app" name="data_app">
                                        Data appuntamento<input id="data_app_cal" type="text" class="form-control col-lg-10" value="" autocomplete="off">
                                    </div>
                                    <div class="col-lg-4">
                                        Ora appuntamento
                                        <select id="ora_app" name="ora_appuntamento" class="form-control">
                                            <option value="">HH:MM</option>
                                            <?php for($h=8;$h < 21;$h++): ?>
                                                <option value="<?=substr("00" . $h,-2)?>:00" <?= !empty($appointment[0]['data_ora_app']) && date('H:i',strtotime($appointment[0]['data_ora_app'])) == (substr("00" . $h,-2) . ":00") ? " selected='selected'" : "" ?>><?=substr("00" . $h,-2)?>:00</option>
                                                <option value="<?=substr("00" . $h,-2)?>:30" <?= !empty($appointment[0]['data_ora_app']) && date('H:i',strtotime($appointment[0]['data_ora_app'])) == (substr("00" . $h,-2) . ":30") ? " selected='selected'" : "" ?>><?=substr("00" . $h,-2)?>:30</option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:30px;">
                                    <div class="col-lg-11" style="padding-left:0;">
                                        Note <textarea name="note_app" id="note_app" class="form-control" rows="5"><?=!empty($appointment[0]['note']) ? $appointment[0]['note'] : ""?></textarea>
                                    </div>
                                </div>
                                <div class="row" style="margin-left:150px;">
                                    <input type="button" value="Salva" id="crea_app" onclick="save_app()" class="btn btn-success">  
                                </div>
                                <div class="row" style="margin-left:30px;">
                                    <div id="esito_app" class="col-lg-10 alert alert-success" style="display:none;"></div>
                                </div>
                            <?=form_close();?>
                <?php else: ?>
                    Nessuna campagna di vendita del macroprodotto della campagna di schedatura presente
                <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>


<script>
    // function invia_presentazione()
    // {
    //     $('#cont_id_update').val($('#id_update').val());

    //     $.ajax({
    //         url: '/invio_presentazione_ajax',
    //         method: "POST",
    //         data: $('#modify_esito_contatto').serialize(),
    //         success: function(res) {
    //             if(res == 'OK')
    //             {
    //                 $('#esito_invio_pres').removeClass('alert-danger');
    //                 $('#esito_invio_pres').addClass('alert-success');
	// 			    $('#esito_invio_pres').html('Presentazione inviata correttamente');
    //                 $('#inviata_presentazione').val('1');
    //             }
    //             else
    //             {
    //                 $('#esito_invio_pres').removeClass('alert-success');
    //                 $('#esito_invio_pres').addClass('alert-danger');
	// 			    $('#esito_invio_pres').html(res);
    //             }
                
                
	// 			$('#esito_invio_pres').show();
	// 			setTimeout(function(){$('#esito_invio_pres').hide();},2500);
    //         },
    //         error: function(err) {
    //             $('#esito_invio_pres').removeClass('alert-success');
    //             $('#esito_invio_pres').addClass('alert-danger');
    //             $('#esito_invio_pres').html(err);
	// 			$('#esito_invio_pres').show();
	// 			setTimeout(function(){$('#esito_contatto_campagna').hide();},2500);
    //         },
    //     });
    // }
    function save_app()
    {
        if($('#camp_vdt').val() == '')
        {
            $('#esito_app').removeClass('alert-success');
            $('#esito_app').addClass('alert-danger');
            $('#esito_app').html('Selezionare la campagna');
            $('#esito_app').show();
            setTimeout(function(){$('#esito_app').hide();},2500);
            return false;
        }

        if($('#vend').val() == '')
        {
            $('#esito_app').removeClass('alert-success');
            $('#esito_app').addClass('alert-danger');
            $('#esito_app').html('Selezionare il venditore');
            $('#esito_app').show();
            setTimeout(function(){$('#esito_app').hide();},2500);
            return false;
        }

        if($('#data_app').val() == '' || $('#ora_app').val() == '')
        {
            $('#esito_app').removeClass('alert-success');
            $('#esito_app').addClass('alert-danger');
            $('#esito_app').html('Selezionare data e ora');
            $('#esito_app').show();
            setTimeout(function(){$('#esito_app').hide();},2500);
            return false;
        }

        $('#cont_id_app').val($('#id_update').val());
        
        dataesito = {'campId':<?=$campId?>,
                    'cont_id_update':$('#id_update').val(),
                    'data_ricontatto':$('#data_ricontatto').val(),
                    'ora_ricontatto':$('#ora_ricontatto').val(),
                    'invio_presentazione':$('#invio_presentazione').is(':checked') ? "1" : "0",
                    'inviata_presentazione':$('#inviata_presentazione').val(),
                    'link_google':$('#link_google').val(),
                    'prodId_Fk':$('#prodotto').val(),
                    'servizio_digitale':$('#servizio_digitale').val(),
                    'id_esito_update_campagna':$('#esito_update_campagna').val(),
                    'note':$('#note').val()};
        const params = new URLSearchParams(dataesito).toString();

        $.ajax({
            url: '/app_webvista_ajax',
            method: "POST",
            data: $('#appointment').serialize() + '&' + params,
            success: function(res) {
                $('#crea_app').hide();
                $('#esito_app').removeClass('alert-danger');
                $('#esito_app').addClass('alert-success');
				$('#esito_app').html('Appuntamento salvato correttamente');
				$('#esito_app').show();
				setTimeout(function(){$('#esito_app').hide();$('#successModal').modal('hide');},2500);

                //inserisco il nuovo csrftoken nel campo per il salvataggio successivo ritornato dal controller
                $('#appointment').find('input[name="<?= csrf_token() ?>"]').val(JSON.parse(res)['csrfHash']);
            },
            error: function(err) {
                $('#esito_app').removeClass('alert-success');
                $('#esito_app').addClass('alert-danger');
                $('#esito_app').html(err);
				$('#esito_app').show();
				setTimeout(function(){$('#esito_app').hide();},2500);
            },
        });
    }

    function caricaVenditori(campid)
    {
        if(campid != '')
        {
            $.ajax({
            url: '/vend_camp_vdt_mcp_ajax/' + campid + '/<?=$macro_prod?>',
            method: "GET",
            data: {},
            success: function(res) {
                utenti = JSON.parse(res);
                
                if(utenti.length == 0)
                {
                    $('#vend').empty();
                    $('#vend').append($('<option>', 
                    {
                            value: "",
                            text: "Nessun venditore trovato"
                    }));
                }
                else
                {
                    $('#vend').empty();
                    $('#vend').append($('<option>', 
                    {
                            value: "",
                            text: "Seleziona..."
                    }));

                    $.each(utenti,function()
                    {
                        $('#vend').append($('<option>', 
                        {
                            value: $(this)[0]['id'],
                            text: $(this)[0]['nome_cognome']
                        }));
                    });
                }
                
            },
            error: function(err) {
               console.log(err);
            },
        });
        }
    }

    function aggiorna_esito()
    {
        if($('#prodotto').val() == '')
        {
            $('#esito_contatto_campagna').removeClass('alert-success');
            $('#esito_contatto_campagna').addClass('alert-danger');
            $('#esito_contatto_campagna').html('Selezionare un prodotto');
            $('#esito_contatto_campagna').show();
            setTimeout(function(){$('#esito_contatto_campagna').hide();},2500);
            return false;
        }

        if($('#esito_update_campagna').val() == '')
        {
            $('#esito_contatto_campagna').removeClass('alert-success');
            $('#esito_contatto_campagna').addClass('alert-danger');
            $('#esito_contatto_campagna').html('Selezionare un esito per aggiornare');
            $('#esito_contatto_campagna').show();
            setTimeout(function(){$('#esito_contatto_campagna').hide();},2500);
            return false;
        }

        $('#cont_id_update').val($('#id_update').val());

         $.ajax({
            url: '/modify_esito_webvista_ajax',
            method: "POST",
            data: $('#modify_esito_contatto').serialize(),
            success: function(res) {
                $('#esito_contatto_campagna').removeClass('alert-danger');
                $('#esito_contatto_campagna').addClass('alert-success');
				$('#esito_contatto_campagna').html('Esito aggiornato correttamente');
				$('#esito_contatto_campagna').show();
				setTimeout(function(){$('#esito_contatto_campagna').hide();},2500);

                //inserisco il nuovo csrftoken nel campo per il salvataggio successivo ritornato dal controller
                $('#modify_esito_contatto').find('input[name="<?= csrf_token() ?>"]').val(JSON.parse(res)['csrfHash']);
            },
            error: function(err) {
                $('#esito_contatto_campagna').removeClass('alert-success');
                $('#esito_contatto_campagna').addClass('alert-danger');
                $('#esito_contatto_campagna').html(err);
				$('#esito_contatto_campagna').show();
				setTimeout(function(){$('#esito_contatto_campagna').hide();},2500);
            },
        });
    }

    $('#data_ricontatto_cal').datepicker({
			closeText: 'Chiudi',
            prevText: 'Precedente',
            nextText: 'Successivo',
            currentText: 'Oggi',
            monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            monthNamesShort: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
            dayNames: ['Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
            weekHeader: 'Sett',
            firstDay: 1, // Start of the week on Monday
            isRTL: false // Left-to-right support
			,dateFormat: 'dd/mm/yy'
			,onSelect: function(dateText) {
				$('#data_ricontatto').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

	<?php if(!empty($cc['data_ricontatto'])): ?> 
			$('#data_ricontatto_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($cc['data_ricontatto']))?>');
			$('#data_ricontatto').val('<?=substr($cc['data_ricontatto'],0,10)?>');
	<?php endif; ?>

     $('#data_app_cal').datepicker({
			closeText: 'Chiudi',
            prevText: 'Precedente',
            nextText: 'Successivo',
            currentText: 'Oggi',
            monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            monthNamesShort: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
            dayNames: ['Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
            weekHeader: 'Sett',
            firstDay: 1, // Start of the week on Monday
            isRTL: false // Left-to-right support
			,dateFormat: 'dd/mm/yy'
			,onSelect: function(dateText) {
				$('#data_app').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

    <?php if(!empty($appointment[0]['data_ora_app'])): ?> 
			$('#data_app_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($appointment[0]['data_ora_app']))?>');
			$('#data_app').val('<?=substr($appointment[0]['data_ora_app'],0,10)?>');
	<?php endif; ?>
</script>