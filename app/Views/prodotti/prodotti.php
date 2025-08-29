<head>
	<meta charset="utf-8">
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

	/* h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;change_status
		padding: 14px 15px 10px 15px;
	} */

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

	td,th
	{
		text-align:center !important;
	}

	h1
	{
		text-align:center !important;
	}
	</style>
</head>

<h1><?=strtoupper($title)?></h1>
<br>
<div class="row">
	<div class="col-lg-1 col-md-3 col-6">
		<a href="javascript:void(0)" onclick="location.href = 'MacroProducts'" class="btn btn-primary btn-md">Macro prodotti</a>
	</div>
    <div class="col-lg-1 col-md-3 col-6 ">
        <a href="javascript:void(0)" onclick="location.href = 'Products'" class="btn btn-primary btn-md">Prodotti</a>
    </div>
    <div class="col-lg-1 col-md-3 col-xs-12">
		<a href="InsertProducts" class='btn btn-success btn-md mt-4 m-sm-0'><i class="material-icons">edit</i> Nuovo</a>
	</div>
</div>
<br>
<?php 
	if(sizeof($prodotti) > 0)
	{
		?>
		<table class="col-lg-6" id="table_prod">
			<thead>
                <th style="border: 1px solid;">Macro prodotto</th>
				<th style="border: 1px solid;">Nome</th>
				<th style="border: 1px solid;border-right:0;">Azioni</th>
				<th style="border: 1px solid;border-left:0;">&nbsp;</th>
			</thead>
			<tbody>
		<?php
		foreach ($prodotti as $prod): 
            //prendo array della macro che ha id come macro del prodotto
            $macro = array_values(array_filter($macroprodotti, function($v) use ($prod) {
                return $v['macroId'] == $prod['macroId_Fk'];
            }));
            ?>
				<tr>
                    <td style="border: 1px solid;"><?=$macro[0]['nome'];?></td>
					<td style="border: 1px solid;"><?=$prod['nome'];?></td>
					<td style="border: 1px solid;border-right:0;">
						<!-- MODIFICA -->
						<a href="<?=base_url()?>index.php/UpdateProducts/<?=$prod['prodId']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
					</td>
					<td style="border: 1px solid;border-left:0;">
						<!-- ELIMINA -->
						<a href="<?=base_url()?>index.php/DeleteProducts/<?=$prod['prodId']?>" class='btn btn-danger'><i class="material-icons">clear</i></a>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	<?php
	}
	else
	{
		?>
		<h3>Nessun prodotto trovato nel DB</h3>
		<?php
	}	

	
	?>