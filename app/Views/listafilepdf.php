<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!--
		script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	<!-- CDN SELECT2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<meta charset="utf-8">
	<title>Lista file PDF</title>

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

	.modal-ku 
	{
  		width: 1350px;
  		margin: auto;
	}
	</style>
</head>
<body>
	
<h2>Lista file PDF</h2>
<br>
<!-- SELECT CON TUTTI I FILE PDF PRESI DAL CONTROLLER->MODEL --> 
<?php 
	if(sizeof($listafilepdf) > 0)
	{
		?>
		<div class="row">
			<div class="col-lg-2">
				<select name="filepdf" id="filepdf" class="form-control">
					<option value="">Seleziona</option>
					<?php
					foreach ($listafilepdf as $id=>$pdf): 
							echo "<option value='" . $id . "'>" . $pdf . "</option>";
					endforeach;
					?>
				</select>
			</div>
			<div class="col-lg-2">
				<input type="button" value="Seleziona" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pdfmodal">
			</div>
		</div>

			<!-- Modal -->
			<div class="modal fade" id="pdfmodal" role="dialog">
				<div class="modal-dialog modal-lg">
				
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4>NOMEFILEPDF</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					
					</div>
					<div class="modal-body">
						<embed src="/pdf/document.pdf" frameborder="0" width="100%" height="400px">
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
				
				</div>
			</div>
		<?php
	}
	else
	{
		?>
		<h3>Nessun file PDF presente</h3>
		<?php
	}	

	
	?>


	<script>
		$(document).ready(function() 
		{
    		$('#filepdf').select2();
		});
	</script>
</body>
</html>
