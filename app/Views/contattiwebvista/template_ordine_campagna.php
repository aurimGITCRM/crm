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
<?=form_open('',array('id' => 'modify_ordine_contatto')); ?>
    <input name="campId_ord" type="hidden" value="<?= $campId ?>">
    <input name="cont_id_update_ord" type="hidden" value="<?=$cc['contId_Fk']?>">
     <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6" style="padding-left:0;">
                    Fatturato&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="fatturato" id="fatturato" value="1" class="custom-checkbox" <?=!empty($cc['fatturato']) && $cc['fatturato'] == 1 ? " checked='checked'" : "" ?>>
                </div>
            </div>
            <div class="row">
                    <div class="col-lg-2" style="padding-left:0;">
                        <input type="hidden" id="data_fattura" name="data_fattura">
                        Data fattura<input id="data_fattura_cal" type="text" class="form-control col-lg-10" value="" autocomplete="off">
                    </div>
            </div>
            <div class="row">
               <div class="col-lg-6" style="padding-left:0;">
                    Pagato&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="pagato" id="pagato" value="1" class="custom-checkbox" <?=!empty($cc['pagato']) && $cc['pagato'] == 1 ? " checked='checked'" : "" ?>>
                </div>
            </div>
             <div class="row">
                    <div class="col-lg-2" style="padding-left:0;">
                        <input type="hidden" id="data_pagamento" name="data_pagamento">
                        Data pagamento<input id="data_pagamento_cal" type="text" class="form-control col-lg-10" value="" autocomplete="off">
                    </div>
            </div>
            <div class="row">
                <div class="col-lg-2" style="padding-left:0;">
                    Prezzo<input type="text" id="prezzo" name="prezzo" value="<?=!empty($cc['prezzo']) ? $cc['prezzo'] : "" ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2" style="padding-left:0;">
                    Sconto<input type="text" id="sconto" name="sconto" value="<?=!empty($cc['sconto']) ? $cc['sconto'] : "" ?>">
                </div>
            </div>
             <div class="row">
                <div class="col-lg-2" style="padding-left:0;">
                    IdOrdine<input type="text" id="idordine" name="idordine" value="<?=!empty($cc['idordine']) ? $cc['idordine'] : "" ?>">
                </div>
            </div>                      
            <div class="row" id="agg_ordine">
                <br>
                <input type="button" class="btn btn-primary btn-lg" value="Aggiorna" onclick="aggiorna_ordine()">
                <br><br>
                <div id="esito_ordine_campagna" class="col-lg-4 alert alert-success" style="display:none;"></div>
            </div>
    </div>
             
<?=form_close();?>


<script>
    function aggiorna_ordine()
    {
         $.ajax({
            url: '/modify_ordine_webvista_ajax',
            method: "POST",
            data: $('#modify_ordine_contatto').serialize(),
            success: function(res) {
                $('#esito_ordine_campagna').removeClass('alert-danger');
                $('#esito_ordine_campagna').addClass('alert-success');
				$('#esito_ordine_campagna').html('Dati ordine aggiornati correttamente');
				$('#esito_ordine_campagna').show();
				setTimeout(function(){$('#esito_ordine_campagna').hide();},2500);

                //inserisco il nuovo csrftoken nel campo per il salvataggio successivo ritornato dal controller
                $('#modify_ordine_contatto').find('input[name="<?= csrf_token() ?>"]').val(JSON.parse(res)['csrfHash']);
            },
            error: function(err) {
                $('#esito_ordine_campagna').removeClass('alert-success');
                $('#esito_ordine_campagna').addClass('alert-danger');
                $('#esito_ordine_campagna').html(err);
				$('#esito_ordine_campagna').show();
				setTimeout(function(){$('#esito_ordine_campagna').hide();},2500);
            },
        });
    }

    $('#data_fattura_cal').datepicker({
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
				$('#data_fattura').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

	<?php if(!empty($cc['data_fattura'])): ?> 
			$('#data_fattura_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($cc['data_fattura']))?>');
			$('#data_fattura').val('<?=substr($cc['data_fattura'],0,10)?>');
	<?php endif; ?>

     $('#data_pagamento_cal').datepicker({
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
				$('#data_pagamento').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

	<?php if(!empty($cc['data_pagamento'])): ?> 
			$('#data_pagamento_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($cc['data_pagamento']))?>');
			$('#data_pagamento').val('<?=substr($cc['data_pagamento'],0,10)?>');
	<?php endif; ?>
</script>
