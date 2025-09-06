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
		margin: 0 0 14px 0;
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
<a href="<?=base_url()?>index.php/Products" class="btn btn-secondary mt-3">
	<i class="material-icons">arrow_back</i> Indietro    
</a>
<br><br>
<?= validation_list_errors() ?>

<?=form_open('modify_prodotto'); ?>

<div id="new_user">
	<div class="col-lg-2 col-12">
        <div class="row">
            <input type="hidden" name="id_update" value="<?=$prodotto[0]['prodId'] ?? ""?>">
            Macro prodotto: <select name="macroId_Fk" class="form-control">
                <option value="">Seleziona...</option>
                <?php foreach($macroprodotti as $macro): ?>
                        <option value="<?=$macro['macroId']?>" <?=!empty($prodotto[0]['macroId_Fk']) && $prodotto[0]['macroId_Fk'] == $macro['macroId'] ? " selected='selected'" : (!empty($macroprodsel) && $macroprodsel == $macro['macroId'] ? " selected='selected'" : "") ?>><?=$macro['nome']?></option>
                <?php endforeach; ?>
            </select>
        </div>
		<div class="row">
			Nome: <input id="name" name="name" type="text" class="form-control" value="<?= !empty($prodotto[0]['nome']) ? $prodotto[0]['nome'] : set_value('name') ?>" autocomplete="off">
		</div>
		<div class="row">
			<input type="submit" name="submit" class="btn btn-primary btn-md" value="Salva" style="margin-top:20px;">
		</div>
	</div>
</div>
<?=form_close()?>






