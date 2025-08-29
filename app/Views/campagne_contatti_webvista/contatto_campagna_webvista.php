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
<a href="Campagne" class="btn btn-secondary mt-3">
	<i class="material-icons">arrow_back</i> Indietro    
</a>
<br><br>

<?php if(!empty($errore_no_cont)): ?> 
	<div class="col-lg-4 alert alert-danger"><?=$errore_no_cont?></div>
<?php else: ?>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" data-toggle="tab" href="#schedacontatto" role="tab">Scheda contatto</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" data-toggle="tab" href="#esito_campagna" role="tab">Esito</a>
	</li>
	<?php if($_SESSION['user_login']['tipo'] == 'venditore'): ?>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#ordine_campagna" role="tab">Ordine</a>
		</li>
	<?php endif; ?>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="schedacontatto" role="tabpanel">
			<?=$template_contatto?>
		</div>
		<div class="tab-pane" id="esito_campagna" role="tabpanel">
			<?=$template_esiti_campagna?>
		</div>
		<?php if($_SESSION['user_login']['tipo'] == 'venditore'): ?>
			<div class="tab-pane" id="ordine_campagna" role="tabpanel">
				<?=$template_ordine_campagna?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?> 






