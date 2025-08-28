
<style>
	body
	{
		text-align:center !important;
	}

	
	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	/* body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	} */

	ul {
	list-style-type: none;
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
<h2><?= $title; ?></h2>

<?php if(!isset($changed)): ?>
	<div class="alert alert-primary" style="text-align:center;" role="alert">
		Compila i campi sottostanti per cambiare la password. Deve contenere almeno 8 lettere, 1 carattere maiuscolo e 1 carattere numerico.
	</div>
<?php endif; ?>

<?= validation_list_errors() ?>

<?php if(!empty($_SESSION['valid_password']) && strlen(validation_list_errors()) == 206): ?> 
	<font class="errors"><?=$_SESSION['valid_password']?></font>
<?php endif; ?> 

<center>
	<?php if(!isset($changed)): ?>
		<div style="width:500px;">
			<?php echo form_open(''); ?>
		
			<label for="old_password">Vecchia Password</label>
			<div class="input-group mb-3">
				<input type="password" name="old_password" value="<?=$_SESSION['password_memory']?>" class="form-control" placeholder="Inserisci la vecchia password" aria-label="Inserisci la vecchia password" aria-describedby="basic-addon1">
			</div>
		
			<label for="password">Nuova Password</label>
			<div class="input-group mb-3">
				<input type="password" name="password" class="form-control" placeholder="Inserisci la nuova password" aria-label="Inserisci la nuova password" aria-describedby="basic-addon1">
			</div>
			
			<label for="pwd_confirm">Conferma Password</label>
			<div class="input-group mb-3">
				<input type="password" name="pwd_confirm" class="form-control" placeholder="Conferma la password" aria-label="Conferma la password" aria-describedby="basic-addon1">
			</div>
			
			<a class="btn btn-secondary btn-md" href="javascript:history.back();">Indietro</a>
			<button type="submit" class="btn btn-primary btn-md">Salva</button>
			
			<?php echo form_close(); ?>
		</div>
	<?php else: ?>
		<div class="alert alert-success">La password è stata aggiornata correttamente</script>
		<script>
			setTimeout(function(){
					location.href = '/LogOut';
				},3000);
		</script>
	<?php endif; ?>
</center>
