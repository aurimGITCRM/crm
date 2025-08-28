<!DOCTYPE html>
<html lang="en">
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
	<script>
    $(function() 
    {
        $('#table_users').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/2.1.8/i18n/it-IT.json"
            },
            columnDefs: [{
                targets: -1, 
                orderable: false
            }],
            "searching": true,
            "paging": true,
            "info": false
            });
    });

	</script>
</head>
<body>
<h1><?=strtoupper($title)?></h1><br>

<div class="row">
	<div class="col-lg-1 col-6">
		<a href="javascript:void(0)" onclick="location.href = '/Users'" class="btn btn-primary btn-md"><i class="material-icons md-18">people</i> Lista utenti</a>
	</div>
	<div class="col-lg-1 col-6">
		<a href="/index.php/InsertUser" class='btn btn-success btn-md'><i class="material-icons">edit</i> Nuovo</a>
	</div>
</div>
<br>
	<!-- STAMPO A VIDEO TUTTI GLI UTENTI --> 
	<div>
		<?= $template_user ?>
	</div>
</body>

