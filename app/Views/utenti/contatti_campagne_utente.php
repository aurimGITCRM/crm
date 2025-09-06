<head>
	<meta charset="utf-8">

	<style type="text/css">
    .material-icons 
	{
        vertical-align: middle !important;
        font-size:30px !important;
    }
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
				$('#table_contatti_campagne_utenti').DataTable({
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
<div align="center"><h1><?=strtoupper($title)?></h1></div>

<div style="width:90%" align="center">
    <br><br>
            <?php if(sizeof($contatti) > 0): ?>
                <table class="col-lg-6" id="table_contatti_campagne_utenti">
                    <thead>
                        <th style="border: 1px solid;text-align:center;">Id</th>
                        <th style="border: 1px solid;text-align:center;">Ragione sociale</th>
                        <th style="border: 1px solid;text-align:center;">Esito</th>
                        <th style="border: 1px solid;text-align:center;">Data primo contatto</th>
                        <th style="border: 1px solid;text-align:center;">Data ricontatto</th>
                        <th style="border: 1px solid;text-align:center;">Inviata presentazione</th>
                        <th style="border: 1px solid;text-align:center;">Prodotto</th>
                        <th style="border: 1px solid;text-align:center;">Servizio</th>
                        <th style="border: 1px solid;border-right:0;text-align:center;">Azioni</th>
                    </thead>
                    <tbody>
                        <?php foreach ($contatti as $c): ?>
                            <tr>
                                <td style="border: 1px solid;text-align:center;"><?=$c['contId_Fk'];?></td>
                                <td style="border: 1px solid;text-align:center;"><?=$c['ragione_sociale'];?></td>
                                <td style="border: 1px solid;text-align:center;"><?=$c['nomeEsito'];?></td>
                                <td style="border: 1px solid;text-align:center;"><?=date('d/m/Y H:i',strtotime($c['data_primo_contatto']))?></td>
                                <td style="border: 1px solid;text-align:center;"><?=date('d/m/Y H:i',strtotime($c['data_ricontatto']))?></td>
                                <td style="border: 1px solid;text-align:center;"><?=$c['invio_presentazione'] == 0 ? "NO" : "SI" ?></td>
                                <td style="border: 1px solid;text-align:center;"><?=$c['prodotto'];?></td>
                                <td style="border: 1px solid;text-align:center;"><?=$c['servizio_digitale'];?></td>
                                <td style="border: 1px solid;border-left:0;text-align:center;">
                                    <a href="/index.php/CampagneContattoUtenteWebVista/<?=$c['campId_Fk'];?>/<?=$c['contId_Fk'];?>"  class='btn btn-success icon-link'>Gestisci contatto <i class="material-icons">edit</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?> 
                <label class="alert alert-danger" id="lblerror">Nessun contatto associato</label>    
            <?php endif; ?>
            
        <?php	
    ?>
</div>