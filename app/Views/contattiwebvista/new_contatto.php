	<title><?=$title?></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 50px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;change_status
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166; $this->load->helper('form');
    $this->load->library('form_validation');
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}

	.row
	{
		margin-bottom:10px !important;
	}

	.radiomod
	{
		-ms-transform: scale(1.5);
		-webkit-transform: scale(1.5);
		transform: scale(1.5);
	}

	input[type="radio"] + label
	{
		display:inline-block;
	}

	.errors
	{
		color:red;
	}

	
	</style>

<script>
	$(document).ready(function()
	{
		 $('#tipologiaId_Fk').select2({
            <?php if (isset($contatto['tipologiaId_Fk']) && !empty($contatto['tipologiaId_Fk'])): ?>
                data: [{
                    id: "<?=$contatto['tipologiaId_Fk']?>",
                    text: "<?=$contatto['nome_tipologia']?>"
                    }],
            <?php else: ?>
                <?php if(isset($tipologiaid_choose) && !empty($tipologiaid_choose)): ?>
                    data: [{
                    id: "<?=$tipologiaid_chooseid_choose?>",
                    text: "<?=$tipologiaid_choosenome_choose?>",
                    }],
                <?php endif; ?>
            <?php endif; ?>
    		language: {
    			inputTooShort: function () {
    				return "Inserire almeno 2 caratteri";
    			},
    			noResults: function () {
    				return "Nessun risultato trovato";
    			}
    		},
    		theme: "bootstrap",
    		minimumInputLength: 2,
    		ajax: {
    			type: 'GET',
    			data: function (params) {
    				var query = {
    					searchTipologia: params.term
    				}
    				return query;
    			},
    			url:"/searchTipologia",
    			dataTypes: 'json',
    			processResults: function (data) {
					console.log(data);
    				var r = JSON.parse(data);
    				return {
    					results: r.results
    				};
    			}
    		}
    	});

		 $('#attId_Fk').select2({
            <?php if (isset($contatto['attId_Fk']) && !empty($contatto['attId_Fk'])): ?>
                data: [{
                    id: "<?=$contatto['attId_Fk']?>",
                    text: "<?=$contatto['nome_attivita']?>"
                    }],
            <?php else: ?>
                <?php if(isset($attid_choose) && !empty($attid_choose)): ?>
                    data: [{
                    id: "<?=$attid_choose?>",
                    text: "<?=$attnome_choose?>",
                    }],
                <?php endif; ?>
            <?php endif; ?>
    		language: {
    			inputTooShort: function () {
    				return "Inserire almeno 2 caratteri";
    			},
    			noResults: function () {
    				return "Nessun risultato trovato";
    			}
    		},
    		theme: "bootstrap",
    		minimumInputLength: 2,
    		ajax: {
    			type: 'GET',
    			data: function (params) {
    				var query = {
    					searchAttivita: params.term
    				}
    				return query;
    			},
    			url:"/searchAttivita",
    			dataTypes: 'json',
    			processResults: function (data) {
					console.log(data);
    				var r = JSON.parse(data);
    				return {
    					results: r.results
    				};
    			}
    		}
    	});

		$('#provincia').select2({
            <?php if (isset($contatto['provincia']) && !empty($contatto['provincia'])): ?>
                data: [{
                    id: "<?=$contatto['provincia']?>",
                    text: "<?=$contatto['provincia']?>"
                    }],
            <?php else: ?>
                <?php if(isset($prov_choose) && !empty($prov_choose)): ?>
                    data: [{
                    id: "<?=$prov_choose?>",
                    text: "<?=$prov_choose?>",
                    }],
                <?php endif; ?>
            <?php endif; ?>
    		language: {
    			inputTooShort: function () {
    				return "Inserire almeno 2 caratteri";
    			},
    			noResults: function () {
    				return "Nessun risultato trovato";
    			}
    		},
    		theme: "bootstrap",
    		minimumInputLength: 2,
    		ajax: {
    			type: 'GET',
    			data: function (params) {
    				var query = {
    					searchProvince: params.term
    				}
    				return query;
    			},
    			url:"/searchProvince",
    			dataTypes: 'json',
    			processResults: function (data) {
					console.log(data);
    				var r = JSON.parse(data);
    				return {
    					results: r.results
    				};
    			}
    		}
    	});

		//inserimento solo numerico
		 $('#telefono,#cellulare').on('input', function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/[^0-9+]/g, '');
        });
	});

	// $(".nav-tabs li.nav-item a.nav-link").click(function() {
  	//  	$(".nav-tabs li.nav-item a.nav-link").removeClass('active');
	// });
	function salva()
	{
		//FARE CONTROLLI DEI CAMPI PRIMA DEL POST 
		errori = '';

		if($('#tipologiaId_Fk').val() == '')
			errori += "Tipologia";
		
		if($('#attId_Fk').val() == '')
			errori += "Attività";
		
		if($('#ragione_sociale').val() == '')
			errori += ", Ragione sociale";

		if($('#referente').val() == '')
			errori += ", Referente";

		if($('#indirizzo').val() == '')
			errori += ", Indirizzo";

		if($('#comune').val() == '')
			errori += ", Comune";

		if($('#provincia').val() == '')
			errori += ", Provincia";

		if($('#cap').val() == '')
			errori += ", Cap";

		if($('#telefono').val() == '')
			errori += ", Telefono";

		if($('#cellulare').val() == '')
			errori += ", Cellulare";

		if($('#email').val() == '')
			errori += ", Email";

		 if(errori == '')
		 {
			$.ajax({
				url: '/modify_contatto_webvista_ajax',
				method: "POST",
				data: $('#modify_contatto').serialize(),
				success: function(res) {
					$('#esito').html('Contatto aggiornato correttamente');
					$('#esito').show();
					setTimeout(function(){$('#esito').hide();},2500);

					//inserisco il nuovo csrftoken nel campo per il salvataggio successivo ritornato dal controller
                	$('#modify_contatto').find('input[name="<?= csrf_token() ?>"]').val(JSON.parse(res)['csrfHash']);
				},
				error: function(err) {
					$('#esito').html(err);
					$('#esito').show();
					setTimeout(function(){$('#esito').hide();},2500);
				},
            });
		 }
		 else
		 {
			$('#esito').html('Correggere i seguenti errori: ' + errori);
			$('#esito').show();
			setTimeout(function(){$('#esito').hide();},2500);
		 }
	}
</script>

<?php if(empty($hide)): ?>
	<a href="/ContattiWebVista" class="btn btn-secondary mt-3">
		<i class="material-icons">arrow_back</i> Indietro    
	</a>
	<br><br>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#schedacontatto" role="tab">Scheda contatto</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#campagne_associate" role="tab">Campagne associate</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#comunicazioni_inviate" role="tab">Comunicazioni inviate</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
	<div class="tab-pane active" id="schedacontatto" role="tabpanel">
		<br>
		<h2><?=$title?></h2>
<?php else: ?>
	<br>
<?php endif; ?>

	<?= validation_list_errors() ?>

		<?=form_open('/index.php/modify_contatto_webvista',array('id' => 'modify_contatto')); ?>
		<div class="row" id="new_user" style="margin-left:0px;">
				<div class="col-lg-3">
					<div class="row">
						<input type="hidden" name="id_update" id="id_update" value="<?=$contatto['contId']?>">
						<label>Tipologia</label><select id="tipologiaId_Fk" name="tipologiaId_Fk" class="form-control"></select>
					</div>
					<div class="row">
						<label>Attivita</label><select id="attId_Fk" name="attId_Fk" class="form-control"></select>
					</div>
					<div class="row">
						<label>Referente</label><input id="ragione_sociale" name="ragione_sociale" type="text" class="form-control" value="<?= !empty($contatto['ragione_sociale']) ? $contatto['ragione_sociale'] : set_value('ragione_sociale') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Ragione sociale</label><input id="referente" name="referente" type="text" class="form-control" value="<?= !empty($contatto['referente']) ? $contatto['referente'] : set_value('referente') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Indirizzo</label><input id="indirizzo" name="indirizzo" type="text" class="form-control" value="<?= !empty($contatto['indirizzo']) ? $contatto['indirizzo'] : set_value('indirizzo') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Comune</label><input id="comune" name="comune" type="text" class="form-control" value="<?= !empty($contatto['comune']) ? $contatto['comune'] : set_value('comune') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Provincia</label><select id="provincia" name="provincia" class="form-control"></select>
					</div>
					<div class="row">
						<label>Cap</label><input id="cap" name="cap" type="text" class="form-control" style="width:50%" value="<?= !empty($contatto['cap']) ? $contatto['cap'] : set_value('cap') ?>" autocomplete="off">
					</div>
				</div>
				<!-- <hr class="col-lg-12 hr"> -->
				<div class="col-lg-1">&nbsp;</div>
				<div class="col-lg-3">
					<div class="row">
						<label>Telefono</label><input id="telefono" name="telefono" type="text" class="form-control" value="<?= !empty($contatto['telefono']) ? $contatto['telefono'] : set_value('telefono') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Cellulare</label><input id="cellulare" name="cellulare" type="text" class="form-control" value="<?= !empty($contatto['cellulare']) ? $contatto['cellulare'] : set_value('cellulare') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Email</label><input id="email" name="email" type="text" class="form-control" value="<?= !empty($contatto['email']) ? $contatto['email'] : set_value('email') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Piva</label><input id="piva" name="piva" type="text" class="form-control" value="<?= !empty($contatto['piva']) ? $contatto['piva'] : set_value('piva') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>CF</label><input id="cf" name="cf" type="text" class="form-control" value="<?= !empty($contatto['cf']) ? $contatto['cf'] : set_value('cf') ?>" autocomplete="off">
					</div>
				</div>
				<div class="col-lg-3">&nbsp;</div>
					
				<!-- <div class="col-lg-1">&nbsp;</div> --> 
				 <hr class="col-lg-12 hr">
				<div class="col-lg-3">
					<div class="row">
						<label>Dominio</label><input id="dominio" name="dominio" type="text" class="form-control" value="<?= !empty($contatto['dominio']) ? $contatto['dominio'] : set_value('dominio') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>User dominio</label><input id="user_dominio" name="user_dominio" type="text" class="form-control" value="<?= !empty($contatto['user_dominio']) ? $contatto['user_dominio'] : set_value('user_dominio') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Pwd dominio</label><input id="pwd_dominio" name="pwd_dominio" type="text" class="form-control" value="<?= !empty($contatto['pwd_dominio']) ? $contatto['pwd_dominio'] : set_value('pwd_dominio') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Email 1</label><input id="email_1" name="email_1" type="text" class="form-control" value="<?= !empty($contatto['email_1']) ? $contatto['email_1'] : set_value('email_1') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Pwd email 1</label><input id="pwd_email_1" name="pwd_email_1" type="text" class="form-control" value="<?= !empty($contatto['pwd_email_1']) ? $contatto['pwd_email_1'] : set_value('pwd_email_1') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Email 2</label><input id="email_2" name="email_2" type="text" class="form-control" value="<?= !empty($contatto['email_2']) ? $contatto['email_2'] : set_value('email_2') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Pwd email 2</label><input id="pwd_email_2" name="pwd_email_2" type="text" class="form-control" value="<?= !empty($contatto['pwd_email_2']) ? $contatto['pwd_email_2'] : set_value('pwd_email_2') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Email 3</label><input id="email_3" name="email_3" type="text" class="form-control" value="<?= !empty($contatto['email_3']) ? $contatto['email_3'] : set_value('email_3') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Pwd email 3</label><input id="pwd_email_3" name="pwd_email_3" type="text" class="form-control" value="<?= !empty($contatto['pwd_email_3']) ? $contatto['pwd_email_3'] : set_value('pwd_email_3') ?>" autocomplete="off">
					</div>
				</div>
				<div class="col-lg-1">&nbsp;</div> 
				<div class="col-lg-3">
					<div class="row">
						<label>User wordpress</label><input id="user_wp" name="user_wp" type="text" class="form-control" value="<?= !empty($contatto['user_wp']) ? $contatto['user_wp'] : set_value('user_wp') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Pwd wordpress</label><input id="pwd_wp" name="pwd_wp" type="text" class="form-control" value="<?= !empty($contatto['pwd_wp']) ? $contatto['pwd_wp'] : set_value('pwd_wp') ?>" autocomplete="off">
					</div>
					<div class="row">
						<label>Ruolo wordpress</label><input id="ruolo_wp" name="ruolo_wp" type="text" class="form-control" value="<?= !empty($contatto['ruolo_wp']) ? $contatto['ruolo_wp'] : set_value('ruolo_wp') ?>" autocomplete="off">
					</div>
					<div class="row">
						<input id="ultimo_agg_plugin" name="ultimo_agg_plugin" type="hidden">
						<label>Ultimo agg plugin</label><input id="ultimo_agg_plugin_cal" name="ultimo_agg_plugin_cal" type="text" class="form-control" value="" autocomplete="off">
					</div>
					<div class="row">
						<input id="data_registrazione_dominio" name="data_registrazione_dominio" type="hidden">
						<label>Data registrazione dominio</label><input id="data_registrazione_dominio_cal" name="data_registrazione_dominio_cal" type="text" class="form-control" value="" autocomplete="off">
					</div>
					<div class="row">
						<input id="data_scadenza_dominio" name="data_scadenza_dominio" type="hidden">
						<label>Data scadenza dominio</label><input id="data_scadenza_dominio_cal" name="data_scadenza_dominio_cal" type="text" class="form-control" value="" autocomplete="off">
					</div>
					<div class="row">
						<label>Rinnovo dominio</label><input type="checkbox" name="rinnovo_dominio" id="rinnovo_dominio" value="1" class="custom-checkbox" <?=!empty($contatto['rinnovo_dominio']) && $contatto['rinnovo_dominio'] == 1 ? " checked='checked'" : "" ?>>
					</div>
					<div class="row">
						<label>Utente</label><?= !empty($contatto['utente']) ? $contatto['utente'] : "" ?></label>
					</div>
					<div class="row">
						<label>Data</label><?= !empty($contatto['data']) ? $contatto['data'] : "" ?></label>
					</div>
				</div>
		</div>
		<div class="row">			
			<?php if(empty($hide)): ?>
				<div class="col-12">
					<input type="submit" name="submit" class="btn btn-primary btn-lg col-12 btn-orange" value="Salva" style="margin-top:20px;">
				</div>
			<?php else: ?>
				<div class="col-12">
					<input type="button" class="btn btn-primary col-12" value="Aggiorna" onclick="salva()">
				</div>

				<div class="col-12">
					<div id="esito" class="col-12 alert alert-success" style="margin-top:30px;display:none;"></div>
				</div>
			<?php endif; ?>
		</div>
		<?=form_close()?>

		

<?php if(empty($hide)): ?>
	</div>
	<div class="tab-pane" id="campagne_associate" role="tabpanel">
		Campagne associate
	</div>
	<div class="tab-pane" id="comunicazioni_inviate" role="tabpanel">
		comunicazioni_inviate
	</div>
	<div class="tab-pane" id="settings" role="tabpanel">...</div>
	</div>
<?php endif; ?>

<script>
	// Formatta data per DB
	function formatDate(date) 
	{
		const day = String(date.getDate()).padStart(2, '0'); // Get day and pad with leading zero
		const month = String(date.getMonth() + 1).padStart(2, '0'); // Get month (0-11) and pad
		const year = date.getFullYear(); // Get full year

		return `${year}-${month}-${day}`; // Format as YYYY-MM-DD
	}

	// Formatta data per calendario
	function formatDateCal(date) 
	{
		const day = String(date.getDate()).padStart(2, '0'); // Get day and pad with leading zero
		const month = String(date.getMonth() + 1).padStart(2, '0'); // Get month (0-11) and pad
		const year = date.getFullYear(); // Get full year

		return `${day}/${month}/${year}`; // Format as YYYY-MM-DD
	}

	  $('#ultimo_agg_plugin_cal').datepicker({
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
				$('#ultimo_agg_plugin').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

	<?php if(!empty($contatto['ultimo_agg_plugin'])): ?> 
			$('#ultimo_agg_plugin_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($contatto['ultimo_agg_plugin']))?>');
			$('#ultimo_agg_plugin').val('<?=substr($contatto['ultimo_agg_plugin'],0,10)?>');
	<?php endif; ?>

	$('#data_registrazione_dominio_cal').datepicker({
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
				$('#data_registrazione_dominio').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
				const originalDate = new Date($('#data_registrazione_dominio').val()); // Original date
				const newDate =  new Date(originalDate.setDate(originalDate.getDate() + 305));
				$('#data_scadenza_dominio').val(formatDate(newDate));
				$('#data_scadenza_dominio_cal').val(formatDateCal(newDate));
			}
	});	

	<?php if(!empty($contatto['data_registrazione_dominio'])): ?> 
			$('#data_registrazione_dominio_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($contatto['data_registrazione_dominio']))?>');
			$('#data_registrazione_dominio').val('<?=substr($contatto['data_registrazione_dominio'],0,10)?>');
	<?php endif; ?>

	$('#data_scadenza_dominio_cal').datepicker({
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
				$('#data_scadenza_dominio').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

	<?php if(!empty($contatto['data_scadenza_dominio'])): ?> 
			$('#data_scadenza_dominio_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($contatto['data_scadenza_dominio']))?>');
			$('#data_scadenza_dominio').val('<?=substr($contatto['data_scadenza_dominio'],0,10)?>');
	<?php endif; ?>
</script>


		








