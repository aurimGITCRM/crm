	<title><?=$title?></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
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
		color: #002166; 
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

<h2><?=$title?></h2>
<a href="/Users" class="btn btn-secondary mt-3">
	<i class="material-icons">arrow_back</i> Indietro    
</a>
<br>
<?= validation_list_errors() ?>

<?=form_open('modify_user'); ?>


<div class="row" id="new_user">
	<div class="col-md-2">
		<div class="row">
			Tipo: <select name="tipo" id="tipo" class="form-control">
						<option value="">Seleziona...</option>
						<option value="schedatore" <?= !empty($user['tipo']) && $user['tipo'] == 'schedatore' ? " selected='selected'" : "" ?>>Schedatore</option>
						<option value="venditore" <?= !empty($user['tipo']) && $user['tipo'] == 'venditore' ? " selected='selected'" : "" ?>>Venditore</option>
						<option value="admin" <?= !empty($user['tipo']) && $user['tipo'] == 'admin' ? " selected='selected'" : "" ?>>Admin</option>
						<option value="sysadmin" <?= !empty($user['tipo']) && $user['tipo'] == 'sysadmin' ? " selected='selected'" : "" ?>>Sysadmin</option>
				  </select>
		</div>	
		<div class="row">
			Username: <input id="username" name="username" type="text" class="form-control" value="<?= !empty($user['username']) ? $user['username'] : set_value('username') ?>" autocomplete="off">
		</div>
	</div>
	<div class="col-md-12">
			<div class="row">
				<div class="col-md-6" style="margin-left:-15px;">	
							Password: <input id="password" name="password" type="<?= empty($user['password']) ? "text" : "hidden"?>" class="form-control" value="<?= !empty($user['password']) ? $user['password'] : set_value('password') ?>" autocomplete="off">
							<input id="password_visual" name="password_visual" <?= !empty($user['password']) ? " disabled='disabled'" : ""?> type="<?= empty($user['password']) ? "hidden" : "text"?>" class="form-control" value="<?= !empty($user['password']) ? $user['password'] : set_value('password') ?>" autocomplete="off">
				</div>
				<div class="col-md-6">	
					<?php if(!empty($user['password'])): ?>
						<a href="javascript:void(0)" onclick="if(confirm('Sei sicuro di resettare la password?')){location.href='/ResettaPwd/<?=$user['id']?>';}" class="btn btn-primary btn-md" style="margin-top:20px;">Resetta Password</a>	
					<?php endif; ?>
				</div>
			</div>
			<?php if(!empty($reset_pwd)): ?>
				<div class="row">					
					<div class="alert alert-success"><?=$reset_pwd?></div>					
				</div>
			<?php endif; ?>
	</div>
		<div class="col-md-2">
		<div class="row">
			<input type="hidden" name="id_update" value="<?=$user['id']?>">
			Nome: <input id="name" name="name" type="text" class="form-control" value="<?= !empty($user['nome']) ? $user['nome'] : set_value('name') ?>" autocomplete="off">
		</div>
		<div class="row">
			Cognome: <input id="surname" name="surname" type="text" class="form-control" value="<?= !empty($user['cognome']) ? $user['cognome'] : set_value('surname') ?>" autocomplete="off">
		</div>
		<div class="row">
			<div class="col-lg-6">
				<input type="radio" name="sesso" value="M" <?php if($user['sesso'] == 'M') echo " checked='checked'" ?>>
				<label>Maschio</label>
			</div>
			<div class="col-lg-6">
				<input type="radio" name="sesso" value="F" <?php if($user['sesso'] == 'F') echo " checked='checked'" ?>>
				<label>Femmina</label>
			</div>
		</div>
		<div class="row">
			Email: <input id="email" name="email" type="text" class="form-control" value="<?=$user['email']?>" autocomplete="off">
		</div>
		<div class="row">
			<input type="hidden" id="data_scadenza" name="data_scadenza">
			Data scadenza: <input id="data_scadenza_cal" type="text" class="form-control" value="" autocomplete="off">
		</div>
		<div class="row">
			<input type="submit" name="submit" class="btn btn-primary btn-md" value="Salva" style="margin-top:20px;">
		</div>
	</div>
</div>
<?=form_close()?>
<script>
	$('#data_scadenza_cal').datepicker({
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
				$('#data_scadenza').val(dateText.split("/")[2] + '-' + dateText.split("/")[1] + '-' + dateText.split("/")[0]);
			}
	});	

	<?php if(!empty($user['data_scadenza'])): ?> 
			$('#data_scadenza_cal').datepicker("setDate",'<?=date('d/m/Y',strtotime($user['data_scadenza']))?>');
			$('#data_scadenza').val('<?=substr($user['data_scadenza'],0,10)?>');
	<?php endif; ?>
</script>





