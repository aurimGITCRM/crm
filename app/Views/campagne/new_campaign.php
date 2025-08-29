	<title><?=$title?></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		/* margin: 40px; */
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
		/* margin: 10px; */
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
<a href="Campagne" class="btn btn-secondary mt-3">
	<i class="material-icons">arrow_back</i> Indietro    
</a>
<br><br>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#schedacampagna" role="tab">Scheda campagna</a>
  </li>

  <?php if(!empty($campagna['campId'])): ?>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#utenti_associati" role="tab">Utenti associati</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#esiti_associati" role="tab">Esiti associati</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#attivita_associate" role="tab">Attività associate</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#macro_prodotti_associati" role="tab">Macro prodotti associati</a>
	</li>
<?php endif;?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane active" id="schedacampagna" role="tabpanel">
		<br>
		<h2><?=$title?></h2>
		<?= validation_list_errors() ?>

		<?=form_open('modify_campagna'); ?>
			<div id="new_user">
				<div class="col-md-2">
					<div class="row">
						<input type="hidden" name="id_update" value="<?=$campagna['campId']?>">
						Nome: <input id="name" name="name" type="text" class="form-control" value="<?= !empty($campagna['campNome']) ? $campagna['campNome'] : set_value('name') ?>" autocomplete="off">
					</div>
					<div class="row">
						Tipo: 
						<select name="tipo" id="tipo" class="form-control">
							<option value="">Seleziona...</option>
							<option value="schedatura" <?= !empty($campagna['campTipo']) && $campagna['campTipo'] == "schedatura" ? " selected='selected'" : "" ?>>Schedatura</option>
							<option value="vendita" <?= !empty($campagna['campTipo']) && $campagna['campTipo'] == "vendita" ? " selected='selected'" : "" ?>>Vendita</option>
						</select>
					</div>
					<div class="row">
						<input type="submit" name="submit" class="btn btn-primary btn-md" value="Salva" style="margin-top:20px;">
					</div>
				</div>
			</div>
		<?=form_close()?>
	</div>
	<div class="tab-pane" id="utenti_associati" role="tabpanel">
		<?=$utenti_campagne; ?>
	</div>
	<div class="tab-pane" id="esiti_associati" role="tabpanel">
		<?=$esiti_campagne; ?>
	</div>
	<div class="tab-pane" id="attivita_associate" role="tabpanel">
		<?=$attivita_campagne; ?>
	</div>
	<div class="tab-pane" id="macro_prodotti_associati" role="tabpanel">
		<?=$macro_campagne; ?>
	</div>
</div>







